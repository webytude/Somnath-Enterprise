<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use App\Http\Resources\LocationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web LocationController.
 *
 * Follows the established API TEMPLATE:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web LocationStoreRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 */
class LocationController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('locations');
    }

    public function index(Request $request): JsonResponse
    {
        $locations = Location::with(['firm', 'department', 'subdepartment', 'division', 'subDivision'])
            ->latest()
            ->get();

        return $this->ok(LocationResource::collection($locations));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'firm_id'          => 'required|exists:firms,id',
            'department_id'    => 'required|exists:departments,id',
            'subdepartment_id' => 'required|exists:subdepartments,id',
            'division_id'      => 'required|exists:divisions,id',
            'sub_division_id'  => 'nullable|exists:sub_divisions,id',
            'name'             => 'required|string|max:255',
            'remark'           => 'nullable|string',
        ]);

        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        $location = Location::create($data);

        return $this->ok(new LocationResource($location), 'Location created.', 201);
    }

    public function show(Location $location): JsonResponse
    {
        $location->load(['firm', 'department', 'subdepartment', 'division', 'subDivision']);

        return $this->ok(new LocationResource($location));
    }

    public function update(Request $request, Location $location): JsonResponse
    {
        $data = $request->validate([
            'firm_id'          => 'required|exists:firms,id',
            'department_id'    => 'nullable|exists:departments,id',
            'subdepartment_id' => 'nullable|exists:subdepartments,id',
            'division_id'      => 'nullable|exists:divisions,id',
            'sub_division_id'  => 'nullable|exists:sub_divisions,id',
            'name'             => 'required|string|max:255',
            'remark'           => 'nullable|string',
        ]);

        $data['updated_by'] = Auth::id();

        $location->update($data);

        return $this->ok(new LocationResource($location), 'Location updated.');
    }

    public function destroy(Location $location): JsonResponse
    {
        $location->delete();

        return $this->ok(null, 'Location deleted.');
    }
}
