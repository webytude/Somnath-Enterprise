<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToolList;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ToolListStoreRequest;

class ToolListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $toolLists = ToolList::with('location')->latest()->get();
        return view('admin.tool-list.index', compact('toolLists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::orderBy('name')->get();
        return view('admin.tool-list.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ToolListStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        
        ToolList::create($data);
        
        return redirect()->route('tool-lists.index')->with('success', 'Tool created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ToolList $toolList)
    {
        return view('admin.tool-list.show', compact('toolList'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ToolList $toolList)
    {
        $locations = Location::orderBy('name')->get();
        return view('admin.tool-list.edit', compact('toolList', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ToolListStoreRequest $request, ToolList $toolList)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        
        $toolList->update($data);
        
        return redirect()->route('tool-lists.index')->with('success', 'Tool updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ToolList $toolList)
    {
        $toolList->delete();
        return redirect()->route('tool-lists.index')->with('success', 'Tool deleted successfully.');
    }
}
