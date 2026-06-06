<?php

namespace App\Http\Controllers\Api;

use App\Models\Department;
use App\Http\Resources\DepartmentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web DepartmentController.
 *
 * This is the TEMPLATE every module's API controller follows:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web FormRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 *
 * For location-scoped models, swap Model::query() for Model::forCurrentUser().
 */
class DepartmentController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('departments');
    }

    public function index(Request $request): JsonResponse
    {
        $departments = Department::with('subdepartments')->latest()->get();

        return $this->ok(DepartmentResource::collection($departments));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
        ]);
        $data['created_by'] = Auth::id();

        $department = Department::create($data);

        return $this->ok(new DepartmentResource($department), 'Department created.', 201);
    }

    public function show(Department $department): JsonResponse
    {
        $department->load('subdepartments');

        return $this->ok(new DepartmentResource($department));
    }

    public function update(Request $request, Department $department): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
        ]);
        $data['updated_by'] = Auth::id();

        $department->update($data);

        return $this->ok(new DepartmentResource($department), 'Department updated.');
    }

    public function destroy(Department $department): JsonResponse
    {
        $department->delete();

        return $this->ok(null, 'Department deleted.');
    }
}
