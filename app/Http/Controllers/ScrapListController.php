<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScrapList;
use App\Models\ScrapMaterial;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ScrapListStoreRequest;

class ScrapListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scrapLists = ScrapList::with('material')->latest()->get();
        return view('admin.scrap-list.index', compact('scrapLists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $scrapMaterials = ScrapMaterial::orderBy('name')->get();
        return view('admin.scrap-list.create', compact('scrapMaterials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ScrapListStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        
        ScrapList::create($data);
        
        return redirect()->route('scrap-lists.index')->with('success', 'Scrap list created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ScrapList $scrapList)
    {
        return view('admin.scrap-list.show', compact('scrapList'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ScrapList $scrapList)
    {
        $scrapMaterials = ScrapMaterial::orderBy('name')->get();
        return view('admin.scrap-list.edit', compact('scrapList', 'scrapMaterials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ScrapListStoreRequest $request, ScrapList $scrapList)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        
        $scrapList->update($data);
        
        return redirect()->route('scrap-lists.index')->with('success', 'Scrap list updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ScrapList $scrapList)
    {
        $scrapList->delete();
        return redirect()->route('scrap-lists.index')->with('success', 'Scrap list deleted successfully.');
    }
}
