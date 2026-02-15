<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteMaterialRequirement;
use App\Models\SiteMaterialRequirementDetail;
use App\Models\Location;
use App\Models\Work;
use App\Models\MaterialCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SiteMaterialRequirementStoreRequest;

class SiteMaterialRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siteMaterialRequirements = SiteMaterialRequirement::with(['location', 'details.material'])->latest()->get();
        return view('admin.site-material-requirement.index', compact('siteMaterialRequirements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::orderBy('name')->get();
        $works = Work::orderBy('name_of_work')->get();
        $materialCategories = MaterialCategory::with('materialLists')->orderBy('name')->get();
        return view('admin.site-material-requirement.create', compact('locations', 'works', 'materialCategories'));
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
                'material_id' => $detail['material_id'],
                'unit' => $detail['unit'],
                'quantity' => $detail['quantity'],
                'date' => $detail['date'],
                'time_within_days' => $detail['time_within_days'] ?? null,
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
        $siteMaterialRequirement->load(['location', 'details.material']);
        return view('admin.site-material-requirement.show', compact('siteMaterialRequirement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SiteMaterialRequirement $siteMaterialRequirement)
    {
        $locations = Location::orderBy('name')->get();
        $works = Work::orderBy('name_of_work')->get();
        $materialCategories = MaterialCategory::with('materialLists')->orderBy('name')->get();
        $siteMaterialRequirement->load('details.material');
        return view('admin.site-material-requirement.edit', compact('siteMaterialRequirement', 'locations', 'works', 'materialCategories'));
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
                'material_id' => $detail['material_id'],
                'unit' => $detail['unit'],
                'quantity' => $detail['quantity'],
                'date' => $detail['date'],
                'time_within_days' => $detail['time_within_days'] ?? null,
                'remark' => $detail['remark'] ?? null,
            ]);
        }
        
        return redirect()->route('site-material-requirements.index')->with('success', 'Site material requirement updated successfully.');
    }

    /**
     * Get materials by category ID
     */
    public function getMaterialsByCategory(Request $request)
    {
        $categoryId = $request->get('category_id');
        $materials = \App\Models\MaterialList::where('material_category_id', $categoryId)
            ->orderBy('name')
            ->get(['id', 'name', 'unit']);
        
        return response()->json($materials);
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
