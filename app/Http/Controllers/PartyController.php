<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Firm;
use App\Models\MaterialCategory;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PartyStoreRequest;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parties = Party::latest()->get();
        return view('admin.party.index', compact('parties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $firms = Firm::orderBy('name')->get();
        $materialCategories = MaterialCategory::with('materialLists')->orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        return view('admin.party.create', compact('firms', 'materialCategories', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PartyStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        
        $materialIds = $request->input('material_ids', []);
        $locationIds = $request->input('location_ids', []);
        
        // Remove material_ids and location_ids from data as they're not fillable
        unset($data['material_ids'], $data['location_ids']);
        
        $party = Party::create($data);
        
        // Sync materials and locations
        if (!empty($materialIds)) {
            $party->materials()->sync($materialIds);
        }
        if (!empty($locationIds)) {
            $party->locations()->sync($locationIds);
        }
        
        return redirect()->route('parties.index')->with('success', 'Party created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Party $party)
    {
        return view('admin.party.show', compact('party'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Party $party)
    {
        $firms = Firm::orderBy('name')->get();
        $materialCategories = MaterialCategory::with('materialLists')->orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $party->load('materials', 'locations');
        return view('admin.party.edit', compact('party', 'firms', 'materialCategories', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PartyStoreRequest $request, Party $party)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        
        $materialIds = $request->input('material_ids', []);
        $locationIds = $request->input('location_ids', []);
        
        // Remove material_ids and location_ids from data as they're not fillable
        unset($data['material_ids'], $data['location_ids']);
        
        $party->update($data);
        
        // Sync materials and locations
        $party->materials()->sync($materialIds);
        $party->locations()->sync($locationIds);
        
        return redirect()->route('parties.index')->with('success', 'Party updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Party $party)
    {
        $party->delete();
        return redirect()->route('parties.index')->with('success', 'Party deleted successfully.');
    }
}
