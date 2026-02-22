<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BillInward;
use App\Models\BillInwardDetail;
use App\Models\Firm;
use App\Models\Party;
use App\Models\MaterialList;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BillInwardStoreRequest;

class BillInwardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $billInwards = BillInward::with(['firm', 'party', 'details.material'])->latest()->get();
        return view('admin.bill-inward.index', compact('billInwards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $firms = Firm::orderBy('name')->get();
        $parties = Party::orderBy('name')->get();
        return view('admin.bill-inward.create', compact('firms', 'parties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BillInwardStoreRequest $request)
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
        if ($request->hasFile('bill_attachment')) {
            $file = $request->file('bill_attachment');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path() . '/images/bill-inwards', $name);
            $data['bill_attachment'] = asset('/images/bill-inwards/' . $name);
        }
        
        // Extract details from data
        $details = $data['details'] ?? [];
        unset($data['details']);
        
        // Create bill inward
        $billInward = BillInward::create($data);
        
        // Create bill inward details
        foreach ($details as $detail) {
            BillInwardDetail::create([
                'bill_inward_id' => $billInward->id,
                'material_id' => $detail['material_id'],
                'quantity' => $detail['quantity'],
                'unit' => $detail['unit'],
                'rate' => $detail['rate'],
                'amount' => $detail['amount'] ?? ($detail['quantity'] * $detail['rate']),
                'gst_percentage' => $detail['gst_percentage'] ?? 0,
                'sub_total' => $detail['sub_total'] ?? 0,
            ]);
        }
        
        return redirect()->route('bill-inwards.index')->with('success', 'Bill inward created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BillInward $billInward)
    {
        $billInward->load(['firm', 'party', 'details.material']);
        return view('admin.bill-inward.show', compact('billInward'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BillInward $billInward)
    {
        $firms = Firm::orderBy('name')->get();
        $parties = Party::orderBy('name')->get();
        $billInward->load('details.material');
        
        // Get current party materials
        $currentPartyMaterials = $billInward->party_id ? Party::with('materials')->find($billInward->party_id)->materials ?? collect() : collect();
        
        return view('admin.bill-inward.edit', compact('billInward', 'firms', 'parties', 'currentPartyMaterials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BillInwardStoreRequest $request, BillInward $billInward)
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
        if ($request->hasFile('bill_attachment')) {
            // Delete old file if exists
            if ($billInward->bill_attachment) {
                $oldFilePath = str_replace(asset(''), '', $billInward->bill_attachment);
                $oldFilePath = ltrim($oldFilePath, '/');
                if (file_exists(public_path($oldFilePath))) {
                    unlink(public_path($oldFilePath));
                }
            }
            
            $file = $request->file('bill_attachment');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path() . '/images/bill-inwards', $name);
            $data['bill_attachment'] = asset('/images/bill-inwards/' . $name);
        }
        
        // Extract details from data
        $details = $data['details'] ?? [];
        unset($data['details']);
        
        // Update bill inward
        $billInward->update($data);
        
        // Delete existing details
        $billInward->details()->delete();
        
        // Create new bill inward details
        foreach ($details as $detail) {
            BillInwardDetail::create([
                'bill_inward_id' => $billInward->id,
                'material_id' => $detail['material_id'],
                'quantity' => $detail['quantity'],
                'unit' => $detail['unit'],
                'rate' => $detail['rate'],
                'amount' => $detail['amount'] ?? ($detail['quantity'] * $detail['rate']),
                'gst_percentage' => $detail['gst_percentage'] ?? 0,
                'sub_total' => $detail['sub_total'] ?? 0,
            ]);
        }
        
        return redirect()->route('bill-inwards.index')->with('success', 'Bill inward updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillInward $billInward)
    {
        // Delete file if exists
        if ($billInward->bill_attachment) {
            $filePath = str_replace(asset(''), '', $billInward->bill_attachment);
            $filePath = ltrim($filePath, '/');
            if (file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
        }
        
        $billInward->details()->delete();
        $billInward->delete();
        return redirect()->route('bill-inwards.index')->with('success', 'Bill inward deleted successfully.');
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

    /**
     * Get materials by party ID
     */
    public function getMaterialsByParty(Request $request)
    {
        $partyId = $request->get('party_id');
        $party = Party::find($partyId);
        
        if ($party) {
            $materials = $party->materials()->orderBy('material_lists.name')->get(['material_lists.id', 'material_lists.name', 'material_lists.unit']);
            return response()->json($materials);
        }
        
        return response()->json([]);
    }
}
