<?php

namespace App\Http\Controllers\Api;

use App\Models\BillOutward;
use App\Models\BillOutwardDetail;
use App\Models\Firm;
use App\Models\Party;
use App\Http\Resources\BillOutwardResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * API counterpart of the web BillOutwardController.
 *
 * Follows the established API template:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors BillOutwardStoreRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 *   - location-scoped: index() uses forCurrentUser()
 *   - nested child/detail rows handled in a DB::transaction
 */
class BillOutwardController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('bill-outwards');
    }

    public function index(Request $request): JsonResponse
    {
        $billOutwards = BillOutward::forCurrentUser()
            ->with(['firm', 'party', 'details.material', 'details.work'])
            ->latest()
            ->get();

        return $this->ok(BillOutwardResource::collection($billOutwards));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());
        $data['created_by'] = Auth::id();

        $billOutward = DB::transaction(function () use ($request, $data) {
            // Get firm GST
            $firm = Firm::find($data['firm_id']);
            if ($firm) {
                $data['firm_gst'] = $firm->gst;
            }

            // Get party GST and Address
            $party = Party::find($data['party_id']);
            if ($party) {
                $data['party_gst'] = $party->gst;
                $data['party_address'] = $party->address;
            }

            // Handle file upload
            if ($request->hasFile('bill_attachment')) {
                $file = $request->file('bill_attachment');
                $name = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . '/images/bill-outwards', $name);
                $data['bill_attachment'] = asset('/images/bill-outwards/' . $name);
            }

            // Calculate deductions if payment status is Received
            if ($data['payment_status'] === 'Received' && isset($data['total_bill_amount'])) {
                $data = $this->applyDeductions($data);
            }

            // Extract details from data
            $details = $data['details'] ?? [];
            unset($data['details']);

            // Create bill outward
            $billOutward = BillOutward::create($data);

            // Create bill outward details
            $this->syncDetails($billOutward, $details);

            return $billOutward;
        });

        $billOutward->load(['firm', 'party', 'details.material', 'details.work']);

        return $this->ok(new BillOutwardResource($billOutward), 'Bill outward created successfully.', 201);
    }

    public function show(BillOutward $billOutward): JsonResponse
    {
        $billOutward->load(['firm', 'party', 'details.material', 'details.work']);

        return $this->ok(new BillOutwardResource($billOutward));
    }

    public function update(Request $request, BillOutward $billOutward): JsonResponse
    {
        $data = $request->validate($this->rules());
        $data['updated_by'] = Auth::id();

        DB::transaction(function () use ($request, $data, $billOutward) {
            // Get firm GST
            $firm = Firm::find($data['firm_id']);
            if ($firm) {
                $data['firm_gst'] = $firm->gst;
            }

            // Get party GST and Address
            $party = Party::find($data['party_id']);
            if ($party) {
                $data['party_gst'] = $party->gst;
                $data['party_address'] = $party->address;
            }

            // Handle file upload
            if ($request->hasFile('bill_attachment')) {
                // Delete old file if exists
                if ($billOutward->bill_attachment) {
                    $oldFilePath = str_replace(asset(''), '', $billOutward->bill_attachment);
                    $oldFilePath = ltrim($oldFilePath, '/');
                    if (file_exists(public_path($oldFilePath))) {
                        unlink(public_path($oldFilePath));
                    }
                }

                $file = $request->file('bill_attachment');
                $name = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . '/images/bill-outwards', $name);
                $data['bill_attachment'] = asset('/images/bill-outwards/' . $name);
            }

            // Calculate deductions if payment status is Received
            if ($data['payment_status'] === 'Received' && isset($data['total_bill_amount'])) {
                $data = $this->applyDeductions($data);
            }

            // Extract details from data
            $details = $data['details'] ?? [];
            unset($data['details']);

            // Update bill outward
            $billOutward->update($data);

            // Delete existing details and recreate
            $billOutward->details()->delete();
            $this->syncDetails($billOutward, $details);
        });

        $billOutward->load(['firm', 'party', 'details.material', 'details.work']);

        return $this->ok(new BillOutwardResource($billOutward), 'Bill outward updated successfully.');
    }

    public function destroy(BillOutward $billOutward): JsonResponse
    {
        // Delete file if exists
        if ($billOutward->bill_attachment) {
            $filePath = str_replace(asset(''), '', $billOutward->bill_attachment);
            $filePath = ltrim($filePath, '/');
            if (file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
        }

        $billOutward->details()->delete();
        $billOutward->delete();

        return $this->ok(null, 'Bill outward deleted successfully.');
    }

    /**
     * Validation rules mirroring BillOutwardStoreRequest.
     *
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'firm_id' => 'required|exists:firms,id',
            'bill_number' => 'nullable|string|max:255',
            'bill_date' => 'nullable|date',
            'bill_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'party_id' => 'required|exists:parties,id',
            'add_bhadu_labour' => 'nullable|numeric|min:0',
            'total_bill_amount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'payment_status' => 'required|in:Pending,Received',
            'sd_percentage' => 'nullable|numeric|min:0|max:100',
            'tds_percentage' => 'nullable|numeric|min:0|max:100',
            'gst_deduction_percentage' => 'nullable|numeric|min:0|max:100',
            'lc_percentage' => 'nullable|numeric|min:0|max:100',
            'tc_percentage' => 'nullable|numeric|min:0|max:100',
            'total_deduction' => 'nullable|numeric|min:0',
            'net_received_amount' => 'nullable|numeric|min:0',
            'payment_ref_number' => 'nullable|string|max:255|required_if:payment_status,Received',
            'payment_date' => 'nullable|date|required_if:payment_status,Received',
            'payment_remarks' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.material_id' => 'nullable|exists:material_lists,id',
            'details.*.work_id' => 'nullable|exists:works,id',
            'details.*.quantity' => 'required|numeric|min:0',
            'details.*.unit' => 'required|string|max:50',
            'details.*.rate' => 'required|numeric|min:0',
            'details.*.amount' => 'nullable|numeric|min:0',
            'details.*.gst_percentage' => 'nullable|numeric|in:0,5,18',
            'details.*.sub_total' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Compute total deduction and net received amount.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function applyDeductions(array $data): array
    {
        $totalBillAmount = $data['total_bill_amount'];
        $totalDeduction = 0;

        if (isset($data['sd_percentage']) && $data['sd_percentage'] > 0) {
            $totalDeduction += ($totalBillAmount * $data['sd_percentage']) / 100;
        }
        if (isset($data['tds_percentage']) && $data['tds_percentage'] > 0) {
            $totalDeduction += ($totalBillAmount * $data['tds_percentage']) / 100;
        }
        if (isset($data['gst_deduction_percentage']) && $data['gst_deduction_percentage'] > 0) {
            $totalDeduction += ($totalBillAmount * $data['gst_deduction_percentage']) / 100;
        }
        if (isset($data['lc_percentage']) && $data['lc_percentage'] > 0) {
            $totalDeduction += ($totalBillAmount * $data['lc_percentage']) / 100;
        }
        if (isset($data['tc_percentage']) && $data['tc_percentage'] > 0) {
            $totalDeduction += ($totalBillAmount * $data['tc_percentage']) / 100;
        }

        $data['total_deduction'] = $totalDeduction;
        $data['net_received_amount'] = $totalBillAmount - $totalDeduction;

        return $data;
    }

    /**
     * Create the child detail rows for a bill outward.
     *
     * @param  array<int, array<string, mixed>>  $details
     */
    protected function syncDetails(BillOutward $billOutward, array $details): void
    {
        foreach ($details as $detail) {
            // Ensure either material_id or work_id is set
            if (empty($detail['material_id']) && empty($detail['work_id'])) {
                continue; // Skip if neither is set
            }

            BillOutwardDetail::create([
                'bill_outward_id' => $billOutward->id,
                'material_id' => $detail['material_id'] ?? null,
                'work_id' => $detail['work_id'] ?? null,
                'quantity' => $detail['quantity'],
                'unit' => $detail['unit'],
                'rate' => $detail['rate'],
                'amount' => $detail['amount'] ?? ($detail['quantity'] * $detail['rate']),
                'gst_percentage' => $detail['gst_percentage'] ?? 0,
                'sub_total' => $detail['sub_total'] ?? 0,
            ]);
        }
    }
}
