<?php

namespace App\Http\Controllers\Api;

use App\Models\SiteMaterialRequirement;
use App\Models\SiteMaterialRequirementDetail;
use App\Http\Resources\SiteMaterialRequirementResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * API counterpart of the web SiteMaterialRequirementController.
 *
 * Follows the established API template:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web FormRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 *
 * Location-scoped: index() uses forCurrentUser() so staff only see their
 * assigned locations' rows. Has child/detail rows handled in a transaction.
 */
class SiteMaterialRequirementController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('site-material-requirements');
    }

    public function index(Request $request): JsonResponse
    {
        $siteMaterialRequirements = SiteMaterialRequirement::forCurrentUser()
            ->with(['location', 'details.material'])
            ->latest()
            ->get();

        return $this->ok(SiteMaterialRequirementResource::collection($siteMaterialRequirements));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'location_id' => 'required|exists:locations,id',
            'work_id' => 'nullable|exists:works,id',
            'details' => 'required|array|min:1',
            'details.*.material_category_id' => 'required|exists:material_categories,id',
            'details.*.material_id' => 'required|exists:material_lists,id',
            'details.*.unit' => 'required|string|max:50',
            'details.*.quantity' => 'required|numeric|min:0',
            'details.*.date' => 'required|date',
            'details.*.time_within_days' => 'nullable|integer|min:0',
            'details.*.remark' => 'nullable|string',
        ]);

        $details = $data['details'] ?? [];
        unset($data['details']);

        $data['created_by'] = Auth::id();

        $siteMaterialRequirement = DB::transaction(function () use ($data, $details) {
            $siteMaterialRequirement = SiteMaterialRequirement::create($data);

            foreach ($details as $detail) {
                SiteMaterialRequirementDetail::create([
                    'site_material_requirement_id' => $siteMaterialRequirement->id,
                    'material_id' => $detail['material_id'],
                    'unit' => $detail['unit'],
                    'quantity' => $detail['quantity'],
                    'date' => $detail['date'],
                    'time_within_days' => $detail['time_within_days'] ?? null,
                    'remark' => $detail['remark'] ?? null,
                ]);
            }

            return $siteMaterialRequirement;
        });

        $siteMaterialRequirement->load(['location', 'details.material']);

        return $this->ok(new SiteMaterialRequirementResource($siteMaterialRequirement), 'Site material requirement created.', 201);
    }

    public function show(SiteMaterialRequirement $siteMaterialRequirement): JsonResponse
    {
        $siteMaterialRequirement->load(['location', 'details.material']);

        return $this->ok(new SiteMaterialRequirementResource($siteMaterialRequirement));
    }

    public function update(Request $request, SiteMaterialRequirement $siteMaterialRequirement): JsonResponse
    {
        $data = $request->validate([
            'location_id' => 'required|exists:locations,id',
            'work_id' => 'nullable|exists:works,id',
            'details' => 'required|array|min:1',
            'details.*.material_category_id' => 'required|exists:material_categories,id',
            'details.*.material_id' => 'required|exists:material_lists,id',
            'details.*.unit' => 'required|string|max:50',
            'details.*.quantity' => 'required|numeric|min:0',
            'details.*.date' => 'required|date',
            'details.*.time_within_days' => 'nullable|integer|min:0',
            'details.*.remark' => 'nullable|string',
        ]);

        $details = $data['details'] ?? [];
        unset($data['details']);

        $data['updated_by'] = Auth::id();

        DB::transaction(function () use ($siteMaterialRequirement, $data, $details) {
            $siteMaterialRequirement->update($data);

            $siteMaterialRequirement->details()->delete();

            foreach ($details as $detail) {
                SiteMaterialRequirementDetail::create([
                    'site_material_requirement_id' => $siteMaterialRequirement->id,
                    'material_id' => $detail['material_id'],
                    'unit' => $detail['unit'],
                    'quantity' => $detail['quantity'],
                    'date' => $detail['date'],
                    'time_within_days' => $detail['time_within_days'] ?? null,
                    'remark' => $detail['remark'] ?? null,
                ]);
            }
        });

        $siteMaterialRequirement->load(['location', 'details.material']);

        return $this->ok(new SiteMaterialRequirementResource($siteMaterialRequirement), 'Site material requirement updated.');
    }

    public function destroy(SiteMaterialRequirement $siteMaterialRequirement): JsonResponse
    {
        DB::transaction(function () use ($siteMaterialRequirement) {
            $siteMaterialRequirement->details()->delete();
            $siteMaterialRequirement->delete();
        });

        return $this->ok(null, 'Site material requirement deleted.');
    }
}
