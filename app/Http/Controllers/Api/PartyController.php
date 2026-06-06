<?php

namespace App\Http\Controllers\Api;

use App\Models\Party;
use App\Http\Resources\PartyResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web PartyController.
 *
 * Follows the established API TEMPLATE:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the PartyStoreRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 *
 * Party is LocationScoped, so index() uses Party::forCurrentUser().
 */
class PartyController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('parties');
    }

    public function index(Request $request): JsonResponse
    {
        $parties = Party::forCurrentUser()->latest()->get();

        return $this->ok(PartyResource::collection($parties));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'firm_id' => 'required|exists:firms,id',
            'gst' => 'nullable|string|max:50',
            'pancard' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'mobile' => 'nullable|string|max:20',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_mobile' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
            'list_of_material' => 'nullable|string',
            'bank_account_holder_name' => 'nullable|string|max:255',
            'bank_name_branch' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
            'material_ids' => 'nullable|array',
            'material_ids.*' => 'exists:material_lists,id',
            'location_ids' => 'nullable|array',
            'location_ids.*' => 'exists:locations,id',
        ]);
        $data['created_by'] = Auth::id();

        $materialIds = $request->input('material_ids', []);
        $locationIds = $request->input('location_ids', []);

        // Remove material_ids and location_ids from data as they're not fillable
        unset($data['material_ids'], $data['location_ids']);

        $party = Party::create($data);

        // Sync materials and locations
        if (!empty($materialIds)) {
            $party->materials()->sync($materialIds);
        }
        if (!empty($locationIds)) {
            $party->locations()->sync($locationIds);
        }

        $party->load('firm', 'materials', 'locations');

        return $this->ok(new PartyResource($party), 'Party created successfully.', 201);
    }

    public function show(Party $party): JsonResponse
    {
        $party->load('firm', 'materials', 'locations');

        return $this->ok(new PartyResource($party));
    }

    public function update(Request $request, Party $party): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'firm_id' => 'required|exists:firms,id',
            'gst' => 'nullable|string|max:50',
            'pancard' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'mobile' => 'nullable|string|max:20',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_mobile' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
            'list_of_material' => 'nullable|string',
            'bank_account_holder_name' => 'nullable|string|max:255',
            'bank_name_branch' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
            'material_ids' => 'nullable|array',
            'material_ids.*' => 'exists:material_lists,id',
            'location_ids' => 'nullable|array',
            'location_ids.*' => 'exists:locations,id',
        ]);
        $data['updated_by'] = Auth::id();

        $materialIds = $request->input('material_ids', []);
        $locationIds = $request->input('location_ids', []);

        // Remove material_ids and location_ids from data as they're not fillable
        unset($data['material_ids'], $data['location_ids']);

        $party->update($data);

        // Sync materials and locations
        $party->materials()->sync($materialIds);
        $party->locations()->sync($locationIds);

        $party->load('firm', 'materials', 'locations');

        return $this->ok(new PartyResource($party), 'Party updated successfully.');
    }

    public function destroy(Party $party): JsonResponse
    {
        $party->delete();

        return $this->ok(null, 'Party deleted successfully.');
    }
}
