<?php

namespace App\Http\Controllers\Api;

use App\Models\SubDivision;
use App\Http\Resources\SubDivisionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web SubDivisionController.
 *
 * Follows the established API template:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web SubDivisionStoreRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 */
class SubDivisionController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('sub-division');
    }

    public function index(Request $request): JsonResponse
    {
        $subDivisions = SubDivision::with('division')->latest()->get();

        return $this->ok(SubDivisionResource::collection($subDivisions));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:sub_divisions,name',
            'division_id' => 'required|exists:divisions,id',
            'head_of_sub_division' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'name_of_sub_div_head' => 'nullable|string|max:255',
            'head_mobile_number' => 'nullable|string|max:20',
            'sub_div_contact_person_name' => 'nullable|string|max:255',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_mobile_number' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
        ]);
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        $subDivision = SubDivision::create($data);

        return $this->ok(new SubDivisionResource($subDivision), 'Sub Division created.', 201);
    }

    public function show(SubDivision $subDivision): JsonResponse
    {
        $subDivision->load('division');

        return $this->ok(new SubDivisionResource($subDivision));
    }

    public function update(Request $request, SubDivision $subDivision): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:sub_divisions,name,' . $subDivision->id,
            'division_id' => 'nullable|exists:divisions,id',
            'head_of_sub_division' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'name_of_sub_div_head' => 'nullable|string|max:255',
            'head_mobile_number' => 'nullable|string|max:20',
            'sub_div_contact_person_name' => 'nullable|string|max:255',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_mobile_number' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
        ]);
        $data['updated_by'] = Auth::id();

        $subDivision->update($data);

        return $this->ok(new SubDivisionResource($subDivision), 'Sub Division updated.');
    }

    public function destroy(SubDivision $subDivision): JsonResponse
    {
        $subDivision->delete();

        return $this->ok(null, 'Sub Division deleted.');
    }
}
