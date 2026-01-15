<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteMaterial;
use App\Models\Location;
use App\Models\Party;
use App\Models\SiteMaterialDetail;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SiteMaterialStoreRequest;

class SiteMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siteMaterials = SiteMaterial::with(['location', 'party', 'details'])->latest()->get();
        return view('admin.site-material.index', compact('siteMaterials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::orderBy('name')->get();
        $parties = Party::orderBy('name')->get();
        return view('admin.site-material.create', compact('locations', 'parties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SiteMaterialStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        $data['is_inward'] = $request->has('is_inward') ? true : false;
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path() . '/images/site-materials', $name);
            $data['photo'] = asset('/images/site-materials/' . $name);
        }
        
        // Extract details from data
        $details = $data['details'] ?? [];
        unset($data['details']);
        
        // Create site material
        $siteMaterial = SiteMaterial::create($data);
        
        // Create material details
        foreach ($details as $detail) {
            SiteMaterialDetail::create([
                'site_material_id' => $siteMaterial->id,
                'material_name' => $detail['material_name'],
                'unit' => $detail['unit'],
                'rate' => $detail['rate'],
                'quantity' => $detail['quantity'],
                'gst' => $detail['gst'] ?? null,
            ]);
        }
        
        return redirect()->route('site-materials.index')->with('success', 'Site material created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SiteMaterial $siteMaterial)
    {
        return view('admin.site-material.show', compact('siteMaterial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SiteMaterial $siteMaterial)
    {
        $locations = Location::orderBy('name')->get();
        $parties = Party::orderBy('name')->get();
        $siteMaterial->load('details');
        return view('admin.site-material.edit', compact('siteMaterial', 'locations', 'parties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SiteMaterialStoreRequest $request, SiteMaterial $siteMaterial)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        $data['is_inward'] = $request->has('is_inward') ? true : false;
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($siteMaterial->photo) {
                $oldPhotoPath = str_replace(asset(''), '', $siteMaterial->photo);
                $oldPhotoPath = ltrim($oldPhotoPath, '/');
                if (file_exists(public_path($oldPhotoPath))) {
                    unlink(public_path($oldPhotoPath));
                }
            }
            
            $image = $request->file('photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path() . '/images/site-materials', $name);
            $data['photo'] = asset('/images/site-materials/' . $name);
        }
        
        // Extract details from data
        $details = $data['details'] ?? [];
        unset($data['details']);
        
        // Update site material
        $siteMaterial->update($data);
        
        // Delete existing details
        $siteMaterial->details()->delete();
        
        // Create new material details
        foreach ($details as $detail) {
            SiteMaterialDetail::create([
                'site_material_id' => $siteMaterial->id,
                'material_name' => $detail['material_name'],
                'unit' => $detail['unit'],
                'rate' => $detail['rate'],
                'quantity' => $detail['quantity'],
                'gst' => $detail['gst'] ?? null,
            ]);
        }
        
        return redirect()->route('site-materials.index')->with('success', 'Site material updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SiteMaterial $siteMaterial)
    {
        // Delete photo if exists
        if ($siteMaterial->photo) {
            $photoPath = str_replace(asset(''), '', $siteMaterial->photo);
            $photoPath = ltrim($photoPath, '/');
            if (file_exists(public_path($photoPath))) {
                unlink(public_path($photoPath));
            }
        }
        
        // Delete related details (cascade should handle this, but being explicit)
        $siteMaterial->details()->delete();
        
        $siteMaterial->delete();
        return redirect()->route('site-materials.index')->with('success', 'Site material deleted successfully.');
    }
}
