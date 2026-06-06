<?php

namespace App\Http\Controllers\Api;

use App\Models\Division;
use App\Http\Resources\DivisionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web DivisionController.
 *
 * Follows the established TEMPLATE:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web FormRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 */
class DivisionController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('division');
    }

    public function index(Request $request): JsonResponse
    {
        $divisions = Division::with(['department', 'subdepartment'])->latest()->get();

        return $this->ok(DivisionResource::collection($divisions));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:divisions,name',
            'department_id' => 'required|exists:departments,id',
            'subdepartment_id' => 'required|exists:subdepartments,id',
            'head_of_division_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'head_mobile_number' => 'nullable|string|max:20',
            'contact_number' => 'nullable|string|max:20',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_mobile_number' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
        ]);
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        $division = Division::create($data);

        return $this->ok(new DivisionResource($division), 'Division created.', 201);
    }

    public function show(Division $division): JsonResponse
    {
        $division->load(['department', 'subdepartment']);

        return $this->ok(new DivisionResource($division));
    }

    public function update(Request $request, Division $division): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:divisions,name,' . $division->id,
            'department_id' => 'nullable|exists:departments,id',
            'subdepartment_id' => 'nullable|exists:subdepartments,id',
            'head_of_division_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'head_mobile_number' => 'nullable|string|max:20',
            'contact_number' => 'nullable|string|max:20',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_mobile_number' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
        ]);
        $data['updated_by'] = Auth::id();

        $division->update($data);

        return $this->ok(new DivisionResource($division), 'Division updated.');
    }

    public function destroy(Division $division): JsonResponse
    {
        $division->delete();

        return $this->ok(null, 'Division deleted.');
    }
}
