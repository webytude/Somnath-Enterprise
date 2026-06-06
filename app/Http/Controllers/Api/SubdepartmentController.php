<?php

namespace App\Http\Controllers\Api;

use App\Models\Subdepartment;
use App\Http\Resources\SubdepartmentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web SubdepartmentController.
 *
 * Follows the established API TEMPLATE:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web controller rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 */
class SubdepartmentController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('sub-departments');
    }

    public function index(Request $request): JsonResponse
    {
        $subdepartments = Subdepartment::with('department')->latest()->get();

        return $this->ok(SubdepartmentResource::collection($subdepartments));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:subdepartments,name',
            'department_id' => 'required|exists:departments,id',
        ]);
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        $subdepartment = Subdepartment::create($data);

        return $this->ok(new SubdepartmentResource($subdepartment), 'Subdepartment created.', 201);
    }

    public function show(Subdepartment $subDepartment): JsonResponse
    {
        $subDepartment->load('department');

        return $this->ok(new SubdepartmentResource($subDepartment));
    }

    public function update(Request $request, Subdepartment $subDepartment): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:subdepartments,name,' . $subDepartment->id,
            'department_id' => 'nullable|exists:departments,id',
        ]);
        $data['updated_by'] = Auth::id();

        $subDepartment->update($data);

        return $this->ok(new SubdepartmentResource($subDepartment), 'Subdepartment updated.');
    }

    public function destroy(Subdepartment $subDepartment): JsonResponse
    {
        $subDepartment->delete();

        return $this->ok(null, 'Subdepartment deleted.');
    }
}
