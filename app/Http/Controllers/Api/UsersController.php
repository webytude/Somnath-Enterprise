<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Hash;

/**
 * API counterpart of the web UsersController.
 *
 * Follows the established API template:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline
 *   - wraps output in a JsonResource
 *
 * The User model is NOT location-scoped, so we use User::query().
 */
class UsersController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('users');
    }

    public function index(Request $request): JsonResponse
    {
        $users = User::with('role')->latest()->get();

        return $this->ok(UserResource::collection($users));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'is_staff' => 'sometimes|boolean',
            'role_id'  => 'nullable|integer|exists:roles,id',
            'phone'    => 'nullable|string|max:255',
            'dob'      => 'nullable|date',
            'address'  => 'nullable|string',
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return $this->ok(new UserResource($user->load('role')), 'User created.', 201);
    }

    public function show(User $user): JsonResponse
    {
        $user->load('role');

        return $this->ok(new UserResource($user));
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'is_staff' => 'sometimes|boolean',
            'role_id'  => 'nullable|integer|exists:roles,id',
            'phone'    => 'nullable|string|max:255',
            'dob'      => 'nullable|date',
            'address'  => 'nullable|string',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return $this->ok(new UserResource($user->load('role')), 'User updated.');
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return $this->ok(null, 'User deleted.');
    }
}
