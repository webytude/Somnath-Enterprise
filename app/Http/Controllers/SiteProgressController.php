<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteProgress;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SiteProgressStoreRequest;

class SiteProgressController extends Controller
{
    /**
     * Get work name options for dropdown
     */
    private function getWorkNameOptions()
    {
        return [
            'Foundation Work',
            'Excavation',
            'Concrete Work',
            'Steel Work',
            'Brick Work',
            'Plastering',
            'Painting',
            'Electrical Work',
            'Plumbing Work',
            'Tiling Work',
            'Carpentry Work',
            'Roofing Work',
            'Flooring Work',
            'Landscaping',
            'Other',
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siteProgress = SiteProgress::latest()->get();
        return view('admin.site-progress.index', compact('siteProgress'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $workNames = $this->getWorkNameOptions();
        return view('admin.site-progress.create', compact('workNames'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SiteProgressStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        
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
        $workNames = $this->getWorkNameOptions();
        return view('admin.site-progress.edit', compact('siteProgress', 'workNames'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SiteProgressStoreRequest $request, SiteProgress $siteProgress)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        
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
