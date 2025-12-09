<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScrapMaterial;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ScrapMaterialStoreRequest;

class ScrapMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scrapMaterials = ScrapMaterial::latest()->get();
        return view('admin.scrap-material.index', compact('scrapMaterials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.scrap-material.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ScrapMaterialStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        
        ScrapMaterial::create($data);
        
        return redirect()->route('scrap-materials.index')->with('success', 'Scrap material created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ScrapMaterial $scrapMaterial)
    {
        return view('admin.scrap-material.show', compact('scrapMaterial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ScrapMaterial $scrapMaterial)
    {
        return view('admin.scrap-material.edit', compact('scrapMaterial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ScrapMaterialStoreRequest $request, ScrapMaterial $scrapMaterial)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        
        $scrapMaterial->update($data);
        
        return redirect()->route('scrap-materials.index')->with('success', 'Scrap material updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ScrapMaterial $scrapMaterial)
    {
        $scrapMaterial->delete();
        return redirect()->route('scrap-materials.index')->with('success', 'Scrap material deleted successfully.');
    }
}
