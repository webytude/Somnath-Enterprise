<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteMaterialRequirement;
use App\Models\SiteMaterialRequirementDetail;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SiteMaterialRequirementStoreRequest;

class SiteMaterialRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siteMaterialRequirements = SiteMaterialRequirement::with(['location', 'details'])->latest()->get();
        return view('admin.site-material-requirement.index', compact('siteMaterialRequirements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::orderBy('name')->get();
        return view('admin.site-material-requirement.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SiteMaterialRequirementStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        
        // Extract details from data
        $details = $data['details'] ?? [];
        unset($data['details']);
        
        // Create site material requirement
        $siteMaterialRequirement = SiteMaterialRequirement::create($data);
        
        // Create requirement details
        foreach ($details as $detail) {
            SiteMaterialRequirementDetail::create([
                'site_material_requirement_id' => $siteMaterialRequirement->id,
                'material_name' => $detail['material_name'],
                'unit' => $detail['unit'],
                'rate' => $detail['rate'],
                'quantity' => $detail['quantity'],
                'date' => $detail['date'],
                'remark' => $detail['remark'] ?? null,
            ]);
        }
        
        return redirect()->route('site-material-requirements.index')->with('success', 'Site material requirement created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SiteMaterialRequirement $siteMaterialRequirement)
    {
        $siteMaterialRequirement->load(['location', 'details']);
        return view('admin.site-material-requirement.show', compact('siteMaterialRequirement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SiteMaterialRequirement $siteMaterialRequirement)
    {
        $locations = Location::orderBy('name')->get();
        $siteMaterialRequirement->load('details');
        return view('admin.site-material-requirement.edit', compact('siteMaterialRequirement', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SiteMaterialRequirementStoreRequest $request, SiteMaterialRequirement $siteMaterialRequirement)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        
        // Extract details from data
        $details = $data['details'] ?? [];
        unset($data['details']);
        
        // Update site material requirement
        $siteMaterialRequirement->update($data);
        
        // Delete existing details
        $siteMaterialRequirement->details()->delete();
        
        // Create new requirement details
        foreach ($details as $detail) {
            SiteMaterialRequirementDetail::create([
                'site_material_requirement_id' => $siteMaterialRequirement->id,
                'material_name' => $detail['material_name'],
                'unit' => $detail['unit'],
                'rate' => $detail['rate'],
                'quantity' => $detail['quantity'],
                'date' => $detail['date'],
                'remark' => $detail['remark'] ?? null,
            ]);
        }
        
        return redirect()->route('site-material-requirements.index')->with('success', 'Site material requirement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SiteMaterialRequirement $siteMaterialRequirement)
    {
        // Delete related details (cascade should handle this, but being explicit)
        $siteMaterialRequirement->details()->delete();
        
        $siteMaterialRequirement->delete();
        return redirect()->route('site-material-requirements.index')->with('success', 'Site material requirement deleted successfully.');
    }
}
