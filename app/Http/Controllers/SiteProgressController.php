<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteProgress;
use App\Models\Location;
use App\Models\Work;
use App\Models\Stage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SiteProgressStoreRequest;

class SiteProgressController extends Controller
{
    /**
     * Get works by location ID
     */
    public function getWorksByLocation(Request $request)
    {
        $locationId = $request->get('location_id');
        $works = Work::where('location_id', $locationId)
            ->orderBy('name_of_work')
            ->get(['id', 'name_of_work']);
        
        return response()->json($works);
    }

    /**
     * Get stages by work ID
     */
    public function getStagesByWork(Request $request)
    {
        $workId = $request->get('work_id');
        $stages = Stage::where('work_id', $workId)
            ->orderBy('name')
            ->get(['id', 'name', 'percentage']);

        return response()->json($stages);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siteProgress = SiteProgress::with('location')->latest()->get();
        return view('admin.site-progress.index', compact('siteProgress'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::orderBy('name')->get();
        return view('admin.site-progress.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SiteProgressStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        
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
        
        SiteProgress::create($data);
        
        return redirect()->route('site-progress.index')->with('success', 'Site progress created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SiteProgress $siteProgress)
    {
        return view('admin.site-progress.show', compact('siteProgress'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SiteProgress $siteProgress)
    {
        $locations = Location::orderBy('name')->get();
        
        // Get current work for the location
        $currentWork = $siteProgress->work_id ? Work::find($siteProgress->work_id) : null;

        // Resolve current selected stage IDs from stored names for edit preselection.
        $selectedStageIds = [];
        if (! empty($siteProgress->work_stage) && $siteProgress->work_id) {
            $stageNames = collect(explode(',', $siteProgress->work_stage))
                ->map(fn ($name) => trim($name))
                ->filter()
                ->values();
            if ($stageNames->isNotEmpty()) {
                $selectedStageIds = Stage::where('work_id', $siteProgress->work_id)
                    ->whereIn('name', $stageNames)
                    ->pluck('id')
                    ->toArray();
            }
        }

        return view('admin.site-progress.edit', compact('siteProgress', 'locations', 'currentWork', 'selectedStageIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SiteProgressStoreRequest $request, SiteProgress $siteProgress)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        
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
        
        return redirect()->route('site-progress.index')->with('success', 'Site progress updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SiteProgress $siteProgress)
    {
        $siteProgress->delete();
        return redirect()->route('site-progress.index')->with('success', 'Site progress deleted successfully.');
    }
}
