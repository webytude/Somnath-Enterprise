<?php

namespace App\Http\Controllers\Api;

use App\Models\Contractor;
use App\Http\Resources\ContractorResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web ContractorController.
 *
 * Follows the established API template:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web FormRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 *
 * Contractor is LocationScoped, so index() uses forCurrentUser().
 */
class ContractorController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('contractors');
    }

    public function index(Request $request): JsonResponse
    {
        $contractors = Contractor::forCurrentUser()->with('paymentSlab')->latest()->get();

        return $this->ok(ContractorResource::collection($contractors));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'pedhi' => 'nullable|string|max:255',
            'gst' => 'nullable|string|max:50',
            'pan' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:255',
            'ifsc' => 'nullable|string|max:20',
            'branch_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'mobile' => 'nullable|string|max:20',
            'contact_person' => 'nullable|string|max:255',
            'contact_person_mobile' => 'nullable|string|max:20',
            'ref_by' => 'nullable|string|max:255',
            'ref_cont_no' => 'nullable|string|max:255',
            'payment_term' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric|min:0',
            'remaining_amount' => 'nullable|numeric|min:0',
            'payment_slab_id' => 'nullable|exists:payment_slabs,id',
            'location_ids' => 'nullable|array',
            'location_ids.*' => 'exists:locations,id',
            'work_ids' => 'nullable|array',
            'work_ids.*' => 'exists:works,id',
        ]);
        $data['created_by'] = Auth::id();

        $locationIds = $request->input('location_ids', []);
        $workIds = $request->input('work_ids', []);

        // Remove location_ids and work_ids from data as they're not fillable
        unset($data['location_ids'], $data['work_ids']);

        $contractor = Contractor::create($data);

        // Sync locations and works
        if (!empty($locationIds)) {
            $contractor->locations()->sync($locationIds);
        }
        if (!empty($workIds)) {
            $contractor->works()->sync($workIds);
        }

        $contractor->load('paymentSlab', 'locations', 'works');

        return $this->ok(new ContractorResource($contractor), 'Contractor/Vendor created.', 201);
    }

    public function show(Contractor $contractor): JsonResponse
    {
        $contractor->load('paymentSlab', 'locations', 'works');

        return $this->ok(new ContractorResource($contractor));
    }

    public function update(Request $request, Contractor $contractor): JsonResponse
    {
        $data = $request->validate([
            'pedhi' => 'nullable|string|max:255',
            'gst' => 'nullable|string|max:50',
            'pan' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:255',
            'ifsc' => 'nullable|string|max:20',
            'branch_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'mobile' => 'nullable|string|max:20',
            'contact_person' => 'nullable|string|max:255',
            'contact_person_mobile' => 'nullable|string|max:20',
            'ref_by' => 'nullable|string|max:255',
            'ref_cont_no' => 'nullable|string|max:255',
            'payment_term' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric|min:0',
            'remaining_amount' => 'nullable|numeric|min:0',
            'payment_slab_id' => 'nullable|exists:payment_slabs,id',
            'location_ids' => 'nullable|array',
            'location_ids.*' => 'exists:locations,id',
            'work_ids' => 'nullable|array',
            'work_ids.*' => 'exists:works,id',
        ]);
        $data['updated_by'] = Auth::id();

        $locationIds = $request->input('location_ids', []);
        $workIds = $request->input('work_ids', []);

        // Remove location_ids and work_ids from data as they're not fillable
        unset($data['location_ids'], $data['work_ids']);

        $contractor->update($data);

        // Sync locations and works
        $contractor->locations()->sync($locationIds);
        $contractor->works()->sync($workIds);

        $contractor->load('paymentSlab', 'locations', 'works');

        return $this->ok(new ContractorResource($contractor), 'Contractor/Vendor updated.');
    }

    public function destroy(Contractor $contractor): JsonResponse
    {
        $contractor->delete();

        return $this->ok(null, 'Contractor/Vendor deleted.');
    }
}
