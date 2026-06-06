<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Http\Resources\RoleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

/**
 * API counterpart of the web RoleController.
 *
 * Follows the established API template:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web controller rules)
 *   - wraps output in a JsonResource
 *
 * Role is NOT location-scoped, so we use standard Eloquent queries.
 */
class RoleController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('roles');
    }

    public function index(Request $request): JsonResponse
    {
        $roles = Role::withCount('permissions')->latest()->get();

        return $this->ok(RoleResource::collection($roles));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $data['name']]);
        $role->permissions()->sync($data['permissions'] ?? []);

        $role->load('permissions');

        return $this->ok(new RoleResource($role), 'Role created.', 201);
    }

    public function show(Role $role): JsonResponse
    {
        $role->load('permissions');

        return $this->ok(new RoleResource($role));
    }

    public function update(Request $request, Role $role): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->fill(['name' => $data['name']]);
        $role->save();

        $role->permissions()->sync($data['permissions'] ?? []);

        // Name unchanged => save() may no-op; permission-only edits don't dirty Role.
        // Always bump roles.updated_at when the form is saved.
        $role->touch();

        $role->load('permissions');

        return $this->ok(new RoleResource($role), 'Role updated.');
    }

    public function destroy(Role $role): JsonResponse
    {
        $role->delete();

        return $this->ok(null, 'Role deleted.');
    }
}
