<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\WorkOrderResource;
use App\Models\Work;
use App\Models\WorkOrder;
use App\Services\WorkOrderNumberService;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * API counterpart of the web WorkOrderController.
 *
 * Follows the established API template:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors WorkOrderStoreRequest)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 *
 * WorkOrder is LocationScoped, so index() uses forCurrentUser().
 */
class WorkOrderController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('work-orders');
    }

    public function index(Request $request): JsonResponse
    {
        $workOrders = WorkOrder::forCurrentUser()
            ->with(['contractor', 'location', 'work'])
            ->latest()
            ->get();

        return $this->ok(WorkOrderResource::collection($workOrders));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules($request, true));

        $workOrder = DB::transaction(function () use ($data) {
            $details = $data['details'];

            $orderDate = Carbon::parse($data['order_date']);
            $number = WorkOrderNumberService::allocateNext(
                $orderDate,
                $data['number_prefix'],
                $data['fiscal_year_label']
            );

            [$total, $normalized] = $this->normalizeDetails($details);

            $workOrder = WorkOrder::create([
                'work_order_number' => $number['work_order_number'],
                'number_prefix' => $number['number_prefix'],
                'fiscal_year_label' => $number['fiscal_year_label'],
                'sequence_number' => $number['sequence_number'],
                'order_date' => $data['order_date'],
                'contractor_id' => $data['contractor_id'],
                'subject' => $data['subject'] ?? null,
                'condition_text' => $data['condition_text'] ?? null,
                'total_order_value' => $total,
                'time_limit_for_work' => $data['time_limit_for_work'] ?? null,
                'payment_condition' => $data['payment_condition'] ?? null,
                'location_id' => $data['location_id'],
                'work_id' => $data['work_id'] ?? null,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            foreach ($normalized as $row) {
                $workOrder->details()->create($row);
            }

            return $workOrder;
        });

        $workOrder->load(['contractor', 'location', 'work', 'details']);

        return $this->ok(new WorkOrderResource($workOrder), 'Work order created.', 201);
    }

    public function show(WorkOrder $workOrder): JsonResponse
    {
        $workOrder->load(['contractor', 'location', 'work', 'details', 'vendorPayments']);

        return $this->ok(new WorkOrderResource($workOrder));
    }

    public function update(Request $request, WorkOrder $workOrder): JsonResponse
    {
        $data = $request->validate($this->rules($request, false));

        DB::transaction(function () use ($data, $workOrder) {
            $details = $data['details'];

            [$total, $normalized] = $this->normalizeDetails($details);

            $workOrder->update([
                'order_date' => $data['order_date'],
                'contractor_id' => $data['contractor_id'],
                'subject' => $data['subject'] ?? null,
                'condition_text' => $data['condition_text'] ?? null,
                'total_order_value' => $total,
                'time_limit_for_work' => $data['time_limit_for_work'] ?? null,
                'payment_condition' => $data['payment_condition'] ?? null,
                'location_id' => $data['location_id'],
                'work_id' => $data['work_id'] ?? null,
                'updated_by' => Auth::id(),
            ]);

            $workOrder->details()->delete();
            foreach ($normalized as $row) {
                $workOrder->details()->create($row);
            }
        });

        $workOrder->load(['contractor', 'location', 'work', 'details']);

        return $this->ok(new WorkOrderResource($workOrder), 'Work order updated.');
    }

    public function destroy(WorkOrder $workOrder): JsonResponse
    {
        $workOrder->delete();

        return $this->ok(null, 'Work order deleted.');
    }

    /**
     * Compute amount/total and normalize detail rows (mirrors the web controller).
     *
     * @return array{0: float, 1: array<int, array<string, mixed>>}
     */
    private function normalizeDetails(array $details): array
    {
        $total = 0;
        $normalized = [];
        foreach ($details as $index => $row) {
            $qty = (float) $row['quantity'];
            $rate = (float) $row['rate'];
            $amount = round($qty * $rate, 2);
            $total += $amount;
            $normalized[] = [
                'sort_order' => $index,
                'work_details' => $row['work_details'],
                'quantity' => $qty,
                'unit' => $row['unit'],
                'rate' => $rate,
                'amount' => $amount,
            ];
        }

        return [$total, $normalized];
    }

    /**
     * Validation rules mirroring WorkOrderStoreRequest.
     * number_prefix / fiscal_year_label are only required on store.
     */
    private function rules(Request $request, bool $isStore): array
    {
        $rules = [
            'order_date' => 'required|date',
            'contractor_id' => 'required|exists:contractors,id',
            'subject' => 'nullable|string',
            'condition_text' => 'nullable|string',
            'time_limit_for_work' => 'nullable|string',
            'payment_condition' => 'nullable|string',
            'location_id' => [
                'required',
                'exists:locations,id',
                function (string $attribute, mixed $value, Closure $fail) use ($request) {
                    $contractorId = $request->input('contractor_id');
                    if (! $contractorId) {
                        return;
                    }
                    $ok = DB::table('contractor_locations')
                        ->where('contractor_id', $contractorId)
                        ->where('location_id', $value)
                        ->exists();
                    if (! $ok) {
                        $fail('The selected location is not assigned to this vendor.');
                    }
                },
            ],
            'work_id' => [
                'nullable',
                'exists:works,id',
                function (string $attribute, mixed $value, Closure $fail) use ($request) {
                    if ($value === null || $value === '') {
                        return;
                    }
                    $contractorId = $request->input('contractor_id');
                    $locationId = $request->input('location_id');
                    if (! $contractorId) {
                        return;
                    }
                    $work = Work::query()->find($value);
                    if (! $work) {
                        $fail('Invalid work.');

                        return;
                    }
                    if ((string) $work->location_id !== (string) $locationId) {
                        $fail('The selected work does not belong to the selected location.');

                        return;
                    }
                    $ok = DB::table('contractor_works')
                        ->where('contractor_id', $contractorId)
                        ->where('work_id', $value)
                        ->exists();
                    if (! $ok) {
                        $fail('The selected work is not assigned to this vendor.');
                    }
                },
            ],
            'details' => 'required|array|min:1',
            'details.*.work_details' => 'required|string',
            'details.*.quantity' => 'required|numeric|min:0',
            'details.*.unit' => 'required|string|max:50',
            'details.*.rate' => 'required|numeric|min:0',
        ];

        if ($isStore) {
            $rules['number_prefix'] = ['required', 'string', 'max:20'];
            $rules['fiscal_year_label'] = ['required', 'string', 'regex:/^\d{4}-\d{2}$/'];
        }

        return $rules;
    }
}
