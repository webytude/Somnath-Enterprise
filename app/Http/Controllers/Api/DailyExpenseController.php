<?php

namespace App\Http\Controllers\Api;

use App\Models\DailyExpense;
use App\Http\Resources\DailyExpenseResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web DailyExpenseController.
 *
 * Follows the established API template:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web FormRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 *
 * DailyExpense is location-scoped, so index() uses forCurrentUser().
 */
class DailyExpenseController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('daily-expense');
    }

    public function index(Request $request): JsonResponse
    {
        $expenses = DailyExpense::forCurrentUser()
            ->with(['staff', 'location'])
            ->latest('date')
            ->latest()
            ->get();

        return $this->ok(DailyExpenseResource::collection($expenses));
    }

    public function store(Request $request): JsonResponse
    {
        // If logged in as staff, staff_id is not required (set automatically).
        $staffIdRule = 'required|exists:staff,id';
        if (Auth::check() && Auth::user()->isStaff() && Auth::user()->staff) {
            $staffIdRule = 'nullable|exists:staff,id';
        }

        $data = $request->validate([
            'staff_id'    => $staffIdRule,
            'location_id' => 'nullable|exists:locations,id',
            'date'        => 'required|date',
            'amount'      => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'remark'      => 'nullable|string',
        ]);

        // If logged in as staff, force their staff_id.
        if (Auth::check() && Auth::user()->isStaff() && Auth::user()->staff) {
            $data['staff_id'] = Auth::user()->staff->id;
        }

        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        $expense = DailyExpense::create($data);

        return $this->ok(new DailyExpenseResource($expense), 'Daily expense created.', 201);
    }

    public function show(DailyExpense $dailyExpense): JsonResponse
    {
        $dailyExpense->load(['staff', 'location']);

        return $this->ok(new DailyExpenseResource($dailyExpense));
    }

    public function update(Request $request, DailyExpense $dailyExpense): JsonResponse
    {
        // If logged in as staff, staff_id is not required (set automatically).
        $staffIdRule = 'required|exists:staff,id';
        if (Auth::check() && Auth::user()->isStaff() && Auth::user()->staff) {
            $staffIdRule = 'nullable|exists:staff,id';
        }

        $data = $request->validate([
            'staff_id'    => $staffIdRule,
            'location_id' => 'nullable|exists:locations,id',
            'date'        => 'required|date',
            'amount'      => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'remark'      => 'nullable|string',
        ]);

        // If logged in as staff, force their staff_id.
        if (Auth::check() && Auth::user()->isStaff() && Auth::user()->staff) {
            $data['staff_id'] = Auth::user()->staff->id;
        }

        $data['updated_by'] = Auth::id();

        $dailyExpense->update($data);

        return $this->ok(new DailyExpenseResource($dailyExpense), 'Daily expense updated.');
    }

    public function destroy(DailyExpense $dailyExpense): JsonResponse
    {
        $dailyExpense->delete();

        return $this->ok(null, 'Daily expense deleted.');
    }
}
