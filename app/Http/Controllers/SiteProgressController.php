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
        $stages = Stage::orderBy('name')->get();
        return view('admin.site-progress.create', compact('locations', 'stages'));
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
        
        // Get stage name from stage_id if stage_id is provided
        if (isset($data['stage_id']) && $data['stage_id']) {
            $stage = Stage::find($data['stage_id']);
            if ($stage) {
                $data['work_stage'] = $stage->name;
            }
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
        $stages = Stage::orderBy('name')->get();
        
        // Get current work for the location
        $currentWork = $siteProgress->work_id ? Work::find($siteProgress->work_id) : null;
        
        return view('admin.site-progress.edit', compact('siteProgress', 'locations', 'stages', 'currentWork'));
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
        
        // Get stage name from stage_id if stage_id is provided
        if (isset($data['stage_id']) && $data['stage_id']) {
            $stage = Stage::find($data['stage_id']);
            if ($stage) {
                $data['work_stage'] = $stage->name;
            }
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
