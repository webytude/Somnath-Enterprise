<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contractor;
use App\Models\PaymentSlab;
use App\Models\Location;
use App\Models\Work;
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
        $locations = Location::orderBy('name')->get();
        return view('admin.contractor.create', compact('paymentSlabs', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContractorStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        
        $locationIds = $request->input('location_ids', []);
        $workIds = $request->input('work_ids', []);
        
        // Remove location_ids and work_ids from data as they're not fillable
        unset($data['location_ids'], $data['work_ids']);
        
        $contractor = Contractor::create($data);
        
        // Sync locations and works
        if (!empty($locationIds)) {
            $contractor->locations()->sync($locationIds);
        }
        if (!empty($workIds)) {
            $contractor->works()->sync($workIds);
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
        $locations = Location::orderBy('name')->get();
        $contractor->load('locations', 'works');
        return view('admin.contractor.edit', compact('contractor', 'paymentSlabs', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContractorStoreRequest $request, Contractor $contractor)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        
        $locationIds = $request->input('location_ids', []);
        $workIds = $request->input('work_ids', []);
        
        // Remove location_ids and work_ids from data as they're not fillable
        unset($data['location_ids'], $data['work_ids']);
        
        $contractor->update($data);
        
        // Sync locations and works
        $contractor->locations()->sync($locationIds);
        $contractor->works()->sync($workIds);
        
        return redirect()->route('contractors.index')->with('success', 'Contractor/Vendor updated successfully.');
    }

    /**
     * Get works by location IDs (for AJAX)
     */
    public function getWorksByLocations(Request $request)
    {
        $locationIds = $request->input('location_ids', []);
        
        if (empty($locationIds)) {
            return response()->json([]);
        }
        
        $works = Work::whereIn('location_id', $locationIds)
            ->orderBy('name_of_work')
            ->get(['id', 'name_of_work', 'location_id']);
        
        return response()->json($works);
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
