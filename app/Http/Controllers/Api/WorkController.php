<?php

namespace App\Http\Controllers\Api;

use App\Models\Work;
use App\Http\Resources\WorkResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web WorkController.
 *
 * Follows the established API TEMPLATE:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the WorkStoreRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 *
 * Work is LocationScoped, so index() uses Work::forCurrentUser().
 */
class WorkController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('works');
    }

    public function index(Request $request): JsonResponse
    {
        $works = Work::forCurrentUser()
            ->with(['firm', 'department', 'subdepartment', 'division', 'subDivision', 'location'])
            ->latest()
            ->get();

        return $this->ok(WorkResource::collection($works));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'firm_id' => 'required|exists:firms,id',
            'department_id' => 'required|exists:departments,id',
            'subdepartment_id' => 'required|exists:subdepartments,id',
            'division_id' => 'required|exists:divisions,id',
            'sub_division_id' => 'nullable|exists:sub_divisions,id',
            'location_id' => 'required|exists:locations,id',
            'name_of_work' => 'required|string|max:255',
            'description_of_work' => 'nullable|string',
            'tender_id' => 'nullable|string|max:255',
            'estimate_cost' => 'nullable|numeric|min:0',
            'equal_above_below_on_estimate' => 'nullable|in:0,+,-',
            'final_amt_of_work' => 'nullable|numeric|min:0',
            'add_18_percent_gst' => 'nullable|numeric|min:0',
            'gst_amount' => 'nullable|numeric|min:0',
            'our_final_work_amt' => 'nullable|numeric|min:0',
            'time_limit_years_months' => 'nullable|string|max:50',
            'work_order_no' => 'nullable|string|max:255',
            'wo_date' => 'nullable|date',
            'end_date_of_work' => 'nullable|date',
            'work_start_date' => 'nullable|date',
            'if_extend_date' => 'nullable|boolean',
            'extended_date' => 'nullable|date',
        ]);

        $data['if_extend_date'] = $request->boolean('if_extend_date');
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        $work = Work::create($data);
        $work->load(['firm', 'department', 'subdepartment', 'division', 'subDivision', 'location']);

        return $this->ok(new WorkResource($work), 'Work created.', 201);
    }

    public function show(Work $work): JsonResponse
    {
        $work->load(['firm', 'department', 'subdepartment', 'division', 'subDivision', 'location']);

        return $this->ok(new WorkResource($work));
    }

    public function update(Request $request, Work $work): JsonResponse
    {
        $data = $request->validate([
            'firm_id' => 'required|exists:firms,id',
            'department_id' => 'nullable|exists:departments,id',
            'subdepartment_id' => 'nullable|exists:subdepartments,id',
            'division_id' => 'nullable|exists:divisions,id',
            'sub_division_id' => 'nullable|exists:sub_divisions,id',
            'location_id' => 'nullable|exists:locations,id',
            'name_of_work' => 'required|string|max:255',
            'description_of_work' => 'nullable|string',
            'tender_id' => 'nullable|string|max:255',
            'estimate_cost' => 'nullable|numeric|min:0',
            'equal_above_below_on_estimate' => 'nullable|in:0,+,-',
            'final_amt_of_work' => 'nullable|numeric|min:0',
            'add_18_percent_gst' => 'nullable|numeric|min:0',
            'gst_amount' => 'nullable|numeric|min:0',
            'our_final_work_amt' => 'nullable|numeric|min:0',
            'time_limit_years_months' => 'nullable|string|max:50',
            'work_order_no' => 'nullable|string|max:255',
            'wo_date' => 'nullable|date',
            'end_date_of_work' => 'nullable|date',
            'work_start_date' => 'nullable|date',
            'if_extend_date' => 'nullable|boolean',
            'extended_date' => 'nullable|date',
        ]);

        $data['if_extend_date'] = $request->boolean('if_extend_date');
        $data['updated_by'] = Auth::id();

        $work->update($data);
        $work->load(['firm', 'department', 'subdepartment', 'division', 'subDivision', 'location']);

        return $this->ok(new WorkResource($work), 'Work updated.');
    }

    public function destroy(Work $work): JsonResponse
    {
        $work->delete();

        return $this->ok(null, 'Work deleted.');
    }
}
