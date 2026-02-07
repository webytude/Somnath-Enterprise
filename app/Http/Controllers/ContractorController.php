<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contractor;
use App\Models\PaymentSlab;
use App\Models\MaterialCategory;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContractorStoreRequest;

class ContractorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contractors = Contractor::with('paymentSlab')->latest()->get();
        return view('admin.contractor.index', compact('contractors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paymentSlabs = PaymentSlab::orderBy('name')->get();
        $materialCategories = MaterialCategory::with('materialLists')->orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        return view('admin.contractor.create', compact('paymentSlabs', 'materialCategories', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContractorStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        
        $materialIds = $request->input('material_ids', []);
        $locationIds = $request->input('location_ids', []);
        
        // Remove material_ids and location_ids from data as they're not fillable
        unset($data['material_ids'], $data['location_ids']);
        
        $contractor = Contractor::create($data);
        
        // Sync materials and locations
        if (!empty($materialIds)) {
            $contractor->materials()->sync($materialIds);
        }
        if (!empty($locationIds)) {
            $contractor->locations()->sync($locationIds);
        }
        
        return redirect()->route('contractors.index')->with('success', 'Contractor/Vendor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contractor $contractor)
    {
        return view('admin.contractor.show', compact('contractor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contractor $contractor)
    {
        $paymentSlabs = PaymentSlab::orderBy('name')->get();
        $materialCategories = MaterialCategory::with('materialLists')->orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $contractor->load('materials', 'locations');
        return view('admin.contractor.edit', compact('contractor', 'paymentSlabs', 'materialCategories', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContractorStoreRequest $request, Contractor $contractor)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        
        $materialIds = $request->input('material_ids', []);
        $locationIds = $request->input('location_ids', []);
        
        // Remove material_ids and location_ids from data as they're not fillable
        unset($data['material_ids'], $data['location_ids']);
        
        $contractor->update($data);
        
        // Sync materials and locations
        $contractor->materials()->sync($materialIds);
        $contractor->locations()->sync($locationIds);
        
        return redirect()->route('contractors.index')->with('success', 'Contractor/Vendor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contractor $contractor)
    {
        $contractor->delete();
        return redirect()->route('contractors.index')->with('success', 'Contractor/Vendor deleted successfully.');
    }
}
