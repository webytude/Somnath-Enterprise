<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialInward;
use App\Models\MaterialInwardDetail;
use App\Models\Location;
use App\Models\Work;
use App\Models\Party;
use App\Models\MaterialList;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MaterialInwardStoreRequest;

class MaterialInwardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materialInwards = MaterialInward::with(['location', 'work', 'party', 'details.material'])->latest()->get();
        return view('admin.material-inward.index', compact('materialInwards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::orderBy('name')->get();
        $works = Work::orderBy('name_of_work')->get();
        $parties = Party::orderBy('name')->get();
        $materials = MaterialList::with('materialCategory')->orderBy('name')->get();
        return view('admin.material-inward.create', compact('locations', 'works', 'parties', 'materials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaterialInwardStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        
        // Get party GST and PAN
        $party = Party::find($data['party_id']);
        if ($party) {
            $data['party_gst'] = $party->gst;
            $data['party_pan'] = $party->pancard;
        }
        
        // Handle file upload
        if ($request->hasFile('bill_voucher_attachment')) {
            $file = $request->file('bill_voucher_attachment');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path() . '/images/material-inwards', $name);
            $data['bill_voucher_attachment'] = asset('/images/material-inwards/' . $name);
        }
        
        // Extract details from data
        $details = $data['details'] ?? [];
        unset($data['details']);
        
        // Create material inward
        $materialInward = MaterialInward::create($data);
        
        // Create material inward details
        foreach ($details as $detail) {
            MaterialInwardDetail::create([
                'material_inward_id' => $materialInward->id,
                'material_id' => $detail['material_id'],
                'make' => $detail['make'] ?? null,
                'quantity' => $detail['quantity'],
                'unit' => $detail['unit'],
                'rate' => $detail['rate'],
                'amount' => $detail['amount'] ?? ($detail['quantity'] * $detail['rate']),
                'gst_percentage' => $detail['gst_percentage'] ?? 0,
                'sub_total' => $detail['sub_total'] ?? 0,
            ]);
        }
        
        return redirect()->route('material-inwards.index')->with('success', 'Material inward created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialInward $materialInward)
    {
        $materialInward->load(['location', 'work', 'party', 'details.material']);
        return view('admin.material-inward.show', compact('materialInward'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaterialInward $materialInward)
    {
        $locations = Location::orderBy('name')->get();
        $works = Work::orderBy('name_of_work')->get();
        $parties = Party::orderBy('name')->get();
        $materials = MaterialList::with('materialCategory')->orderBy('name')->get();
        $materialInward->load('details.material');
        return view('admin.material-inward.edit', compact('materialInward', 'locations', 'works', 'parties', 'materials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MaterialInwardStoreRequest $request, MaterialInward $materialInward)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        
        // Get party GST and PAN
        $party = Party::find($data['party_id']);
        if ($party) {
            $data['party_gst'] = $party->gst;
            $data['party_pan'] = $party->pancard;
        }
        
        // Handle file upload
        if ($request->hasFile('bill_voucher_attachment')) {
            // Delete old file if exists
            if ($materialInward->bill_voucher_attachment) {
                $oldFilePath = str_replace(asset(''), '', $materialInward->bill_voucher_attachment);
                $oldFilePath = ltrim($oldFilePath, '/');
                if (file_exists(public_path($oldFilePath))) {
                    unlink(public_path($oldFilePath));
                }
            }
            
            $file = $request->file('bill_voucher_attachment');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path() . '/images/material-inwards', $name);
            $data['bill_voucher_attachment'] = asset('/images/material-inwards/' . $name);
        }
        
        // Extract details from data
        $details = $data['details'] ?? [];
        unset($data['details']);
        
        // Update material inward
        $materialInward->update($data);
        
        // Delete existing details
        $materialInward->details()->delete();
        
        // Create new material inward details
        foreach ($details as $detail) {
            MaterialInwardDetail::create([
                'material_inward_id' => $materialInward->id,
                'material_id' => $detail['material_id'],
                'make' => $detail['make'] ?? null,
                'quantity' => $detail['quantity'],
                'unit' => $detail['unit'],
                'rate' => $detail['rate'],
                'amount' => $detail['amount'] ?? ($detail['quantity'] * $detail['rate']),
                'gst_percentage' => $detail['gst_percentage'] ?? 0,
                'sub_total' => $detail['sub_total'] ?? 0,
            ]);
        }
        
        return redirect()->route('material-inwards.index')->with('success', 'Material inward updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaterialInward $materialInward)
    {
        // Delete file if exists
        if ($materialInward->bill_voucher_attachment) {
            $filePath = str_replace(asset(''), '', $materialInward->bill_voucher_attachment);
            $filePath = ltrim($filePath, '/');
            if (file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
        }
        
        $materialInward->details()->delete();
        $materialInward->delete();
        return redirect()->route('material-inwards.index')->with('success', 'Material inward deleted successfully.');
    }

    /**
     * Get party details by AJAX
     */
    public function getPartyDetails(Request $request)
    {
        $party = Party::find($request->party_id);
        if ($party) {
            return response()->json([
                'gst' => $party->gst,
                'pan' => $party->pancard,
            ]);
        }
        return response()->json(['gst' => '', 'pan' => '']);
    }
}
