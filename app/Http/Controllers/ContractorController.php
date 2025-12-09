<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contractor;
use App\Models\PaymentSlab;
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
        return view('admin.contractor.create', compact('paymentSlabs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContractorStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        
        Contractor::create($data);
        
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
        return view('admin.contractor.edit', compact('contractor', 'paymentSlabs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContractorStoreRequest $request, Contractor $contractor)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        
        $contractor->update($data);
        
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
