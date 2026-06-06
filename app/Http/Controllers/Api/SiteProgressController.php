<?php

namespace App\Http\Controllers\Api;

use App\Models\SiteProgress;
use App\Models\Work;
use App\Models\Stage;
use App\Http\Resources\SiteProgressResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web SiteProgressController.
 *
 * Follows the established API template:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web SiteProgressStoreRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 *
 * SiteProgress is location-scoped, so index() uses forCurrentUser().
 */
class SiteProgressController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('site-progress');
    }

    public function index(Request $request): JsonResponse
    {
        $siteProgress = SiteProgress::forCurrentUser()->with('location')->latest()->get();

        return $this->ok(SiteProgressResource::collection($siteProgress));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'location_id' => 'required|exists:locations,id',
            'work_id' => 'nullable|exists:works,id',
            'stage_ids' => 'nullable|array',
            'stage_ids.*' => 'exists:stages,id',
            'work_name' => 'nullable|string|max:255',
            'work_site' => 'required|string|max:255',
            'work_stage' => 'nullable|string',
            'stage_id' => 'nullable|exists:stages,id',
            'stage_percentage' => 'nullable|numeric|min:0|max:100',
            'remark' => 'nullable|string',
            'photo_url' => 'nullable|url|max:500',
            'date' => 'required|date',
        ]);
        $data['created_by'] = Auth::id();

        // Get work name from work_id if work_id is provided
        if (isset($data['work_id']) && $data['work_id']) {
            $work = Work::find($data['work_id']);
            if ($work) {
                $data['work_name'] = $work->name_of_work;
                $data['work_site'] = $work->name_of_work;
            }
        }

        // Build work stage list and total percentage from selected stages.
        $selectedStageIds = array_values($request->input('stage_ids', []));
        if (! empty($selectedStageIds)) {
            $selectedStages = Stage::whereIn('id', $selectedStageIds)->orderBy('name')->get();
            $data['work_stage'] = $selectedStages->pluck('name')->implode(', ');
            $data['stage_percentage'] = (float) $selectedStages->sum('percentage');
            $data['stage_id'] = $selectedStages->first()?->id; // legacy column compatibility
        } else {
            $data['work_stage'] = null;
            $data['stage_percentage'] = null;
            $data['stage_id'] = null;
        }

        $siteProgress = SiteProgress::create($data);

        return $this->ok(new SiteProgressResource($siteProgress), 'Site progress created.', 201);
    }

    public function show(SiteProgress $siteProgress): JsonResponse
    {
        $siteProgress->load('location');

        return $this->ok(new SiteProgressResource($siteProgress));
    }

    public function update(Request $request, SiteProgress $siteProgress): JsonResponse
    {
        $data = $request->validate([
            'location_id' => 'required|exists:locations,id',
            'work_id' => 'nullable|exists:works,id',
            'stage_ids' => 'nullable|array',
            'stage_ids.*' => 'exists:stages,id',
            'work_name' => 'nullable|string|max:255',
            'work_site' => 'required|string|max:255',
            'work_stage' => 'nullable|string',
            'stage_id' => 'nullable|exists:stages,id',
            'stage_percentage' => 'nullable|numeric|min:0|max:100',
            'remark' => 'nullable|string',
            'photo_url' => 'nullable|url|max:500',
            'date' => 'required|date',
        ]);
        $data['updated_by'] = Auth::id();

        // Get work name from work_id if work_id is provided
        if (isset($data['work_id']) && $data['work_id']) {
            $work = Work::find($data['work_id']);
            if ($work) {
                $data['work_name'] = $work->name_of_work;
                $data['work_site'] = $work->name_of_work;
            }
        }

        // Build work stage list and total percentage from selected stages.
        $selectedStageIds = array_values($request->input('stage_ids', []));
        if (! empty($selectedStageIds)) {
            $selectedStages = Stage::whereIn('id', $selectedStageIds)->orderBy('name')->get();
            $data['work_stage'] = $selectedStages->pluck('name')->implode(', ');
            $data['stage_percentage'] = (float) $selectedStages->sum('percentage');
            $data['stage_id'] = $selectedStages->first()?->id; // legacy column compatibility
        } else {
            $data['work_stage'] = null;
            $data['stage_percentage'] = null;
            $data['stage_id'] = null;
        }

        $siteProgress->update($data);

        return $this->ok(new SiteProgressResource($siteProgress), 'Site progress updated.');
    }

    public function destroy(SiteProgress $siteProgress): JsonResponse
    {
        $siteProgress->delete();

        return $this->ok(null, 'Site progress deleted.');
    }
}
