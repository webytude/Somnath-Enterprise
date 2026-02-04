<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Firm;
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
        return view('admin.party.create', compact('firms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PartyStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        
        Party::create($data);
        
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
        return view('admin.party.edit', compact('party', 'firms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PartyStoreRequest $request, Party $party)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        
        $party->update($data);
        
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
