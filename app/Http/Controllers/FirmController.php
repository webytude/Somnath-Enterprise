<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Firm;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FirmStoreRequest;

class FirmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $firms = Firm::latest()->get();
        return view('admin.firm.index', compact('firms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.firm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FirmStoreRequest $request)
    {
        Firm::create([
            'name' => $request->name,
            'address' => $request->address,
            'pancard' => $request->pancard,
            'gst' => $request->gst,
            'pf_code' => $request->pf_code,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'bank_name' => $request->bank_name,
            'bank_account_no' => $request->bank_account_no,
            'ifsc_code' => $request->ifsc_code,
            'head_name' => $request->head_name,
            'head_mobile_number' => $request->head_mobile_number,
            'remark' => $request->remark,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('firms.index')
            ->with('success', 'Firm created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $firm = Firm::findOrFail($id);
        return view('admin.firm.edit', compact('firm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FirmStoreRequest $request, string $id)
    {
        $firm = Firm::findOrFail($id);
        $firm->update([
            'name' => $request->name,
            'address' => $request->address,
            'pancard' => $request->pancard,
            'gst' => $request->gst,
            'pf_code' => $request->pf_code,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'bank_name' => $request->bank_name,
            'bank_account_no' => $request->bank_account_no,
            'ifsc_code' => $request->ifsc_code,
            'head_name' => $request->head_name,
            'head_mobile_number' => $request->head_mobile_number,
            'remark' => $request->remark,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('firms.index')
            ->with('success', 'Firm updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $firm = Firm::findOrFail($id);
        $firm->delete();
        return redirect()->route('firms.index')
            ->with('success', 'Firm deleted successfully.');
    }
}
