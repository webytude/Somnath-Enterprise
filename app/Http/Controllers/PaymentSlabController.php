<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentSlab;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaymentSlabStoreRequest;

class PaymentSlabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentSlabs = PaymentSlab::latest()->get();
        return view('admin.payment-slab.index', compact('paymentSlabs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payment-slab.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentSlabStoreRequest $request)
    {
        PaymentSlab::create([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('payment-slabs.index')->with('success', 'Payment slab created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentSlab $paymentSlab)
    {
        return view('admin.payment-slab.show', compact('paymentSlab'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentSlab $paymentSlab)
    {
        return view('admin.payment-slab.edit', compact('paymentSlab'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentSlabStoreRequest $request, PaymentSlab $paymentSlab)
    {
        $paymentSlab->update([
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
        ]);

        return redirect()->route('payment-slabs.index')->with('success', 'Payment slab updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentSlab $paymentSlab)
    {
        $paymentSlab->delete();
        return redirect()->route('payment-slabs.index')->with('success', 'Payment slab deleted successfully.');
    }
}
