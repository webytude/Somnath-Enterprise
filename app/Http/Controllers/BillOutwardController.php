<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BillOutward;
use App\Models\BillOutwardDetail;
use App\Models\Firm;
use App\Models\Party;
use App\Models\MaterialList;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BillOutwardStoreRequest;

class BillOutwardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $billOutwards = BillOutward::with(['firm', 'party', 'details.material', 'details.work'])->latest()->get();
        return view('admin.bill-outward.index', compact('billOutwards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $firms = Firm::orderBy('name')->get();
        $parties = Party::orderBy('name')->get();
        return view('admin.bill-outward.create', compact('firms', 'parties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BillOutwardStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        
        // Get firm GST
        $firm = Firm::find($data['firm_id']);
        if ($firm) {
            $data['firm_gst'] = $firm->gst;
        }
        
        // Get party GST and Address
        $party = Party::find($data['party_id']);
        if ($party) {
            $data['party_gst'] = $party->gst;
            $data['party_address'] = $party->address;
        }
        
        // Handle file upload
        if ($request->hasFile('bill_attachment')) {
            $file = $request->file('bill_attachment');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path() . '/images/bill-outwards', $name);
            $data['bill_attachment'] = asset('/images/bill-outwards/' . $name);
        }
        
        // Calculate deductions if payment status is Received
        if ($data['payment_status'] === 'Received' && isset($data['total_bill_amount'])) {
            $totalBillAmount = $data['total_bill_amount'];
            $totalDeduction = 0;
            
            if (isset($data['sd_percentage']) && $data['sd_percentage'] > 0) {
                $totalDeduction += ($totalBillAmount * $data['sd_percentage']) / 100;
            }
            if (isset($data['tds_percentage']) && $data['tds_percentage'] > 0) {
                $totalDeduction += ($totalBillAmount * $data['tds_percentage']) / 100;
            }
            if (isset($data['gst_deduction_percentage']) && $data['gst_deduction_percentage'] > 0) {
                $totalDeduction += ($totalBillAmount * $data['gst_deduction_percentage']) / 100;
            }
            if (isset($data['lc_percentage']) && $data['lc_percentage'] > 0) {
                $totalDeduction += ($totalBillAmount * $data['lc_percentage']) / 100;
            }
            if (isset($data['tc_percentage']) && $data['tc_percentage'] > 0) {
                $totalDeduction += ($totalBillAmount * $data['tc_percentage']) / 100;
            }
            
            $data['total_deduction'] = $totalDeduction;
            $data['net_received_amount'] = $totalBillAmount - $totalDeduction;
        }
        
        // Extract details from data
        $details = $data['details'] ?? [];
        unset($data['details']);
        
        // Create bill outward
        $billOutward = BillOutward::create($data);
        
        // Create bill outward details
        foreach ($details as $detail) {
            // Ensure either material_id or work_id is set
            if (empty($detail['material_id']) && empty($detail['work_id'])) {
                continue; // Skip if neither is set
            }
            
            BillOutwardDetail::create([
                'bill_outward_id' => $billOutward->id,
                'material_id' => $detail['material_id'] ?? null,
                'work_id' => $detail['work_id'] ?? null,
                'quantity' => $detail['quantity'],
                'unit' => $detail['unit'],
                'rate' => $detail['rate'],
                'amount' => $detail['amount'] ?? ($detail['quantity'] * $detail['rate']),
                'gst_percentage' => $detail['gst_percentage'] ?? 0,
                'sub_total' => $detail['sub_total'] ?? 0,
            ]);
        }
        
        return redirect()->route('bill-outwards.index')->with('success', 'Bill outward created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BillOutward $billOutward)
    {
        $billOutward->load(['firm', 'party', 'details.material', 'details.work']);
        return view('admin.bill-outward.show', compact('billOutward'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BillOutward $billOutward)
    {
        $firms = Firm::orderBy('name')->get();
        $parties = Party::orderBy('name')->get();
        $billOutward->load('details.material', 'details.work');
        
        // Get current party materials and works
        $currentParty = $billOutward->party_id ? Party::with(['materials', 'locations'])->find($billOutward->party_id) : null;
        $currentPartyMaterials = $currentParty && $currentParty->materials ? $currentParty->materials : collect();
        
        // Get works from party locations
        $currentPartyWorks = collect();
        if ($currentParty && $currentParty->locations) {
            $locationIds = $currentParty->locations->pluck('id');
            $currentPartyWorks = Work::whereIn('location_id', $locationIds)->orderBy('name_of_work')->get();
        }
        
        // Also include works that are already selected in the details (in case they're not in party locations)
        $existingWorkIds = $billOutward->details->whereNotNull('work_id')->pluck('work_id')->unique();
        if ($existingWorkIds->isNotEmpty()) {
            $existingWorks = Work::whereIn('id', $existingWorkIds)->orderBy('name_of_work')->get();
            // Merge with current party works, avoiding duplicates
            $currentPartyWorks = $currentPartyWorks->merge($existingWorks)->unique('id')->values();
        }
        
        return view('admin.bill-outward.edit', compact('billOutward', 'firms', 'parties', 'currentPartyMaterials', 'currentPartyWorks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BillOutwardStoreRequest $request, BillOutward $billOutward)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        
        // Get firm GST
        $firm = Firm::find($data['firm_id']);
        if ($firm) {
            $data['firm_gst'] = $firm->gst;
        }
        
        // Get party GST and Address
        $party = Party::find($data['party_id']);
        if ($party) {
            $data['party_gst'] = $party->gst;
            $data['party_address'] = $party->address;
        }
        
        // Handle file upload
        if ($request->hasFile('bill_attachment')) {
            // Delete old file if exists
            if ($billOutward->bill_attachment) {
                $oldFilePath = str_replace(asset(''), '', $billOutward->bill_attachment);
                $oldFilePath = ltrim($oldFilePath, '/');
                if (file_exists(public_path($oldFilePath))) {
                    unlink(public_path($oldFilePath));
                }
            }
            
            $file = $request->file('bill_attachment');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path() . '/images/bill-outwards', $name);
            $data['bill_attachment'] = asset('/images/bill-outwards/' . $name);
        }
        
        // Calculate deductions if payment status is Received
        if ($data['payment_status'] === 'Received' && isset($data['total_bill_amount'])) {
            $totalBillAmount = $data['total_bill_amount'];
            $totalDeduction = 0;
            
            if (isset($data['sd_percentage']) && $data['sd_percentage'] > 0) {
                $totalDeduction += ($totalBillAmount * $data['sd_percentage']) / 100;
            }
            if (isset($data['tds_percentage']) && $data['tds_percentage'] > 0) {
                $totalDeduction += ($totalBillAmount * $data['tds_percentage']) / 100;
            }
            if (isset($data['gst_deduction_percentage']) && $data['gst_deduction_percentage'] > 0) {
                $totalDeduction += ($totalBillAmount * $data['gst_deduction_percentage']) / 100;
            }
            if (isset($data['lc_percentage']) && $data['lc_percentage'] > 0) {
                $totalDeduction += ($totalBillAmount * $data['lc_percentage']) / 100;
            }
            if (isset($data['tc_percentage']) && $data['tc_percentage'] > 0) {
                $totalDeduction += ($totalBillAmount * $data['tc_percentage']) / 100;
            }
            
            $data['total_deduction'] = $totalDeduction;
            $data['net_received_amount'] = $totalBillAmount - $totalDeduction;
        }
        
        // Extract details from data
        $details = $data['details'] ?? [];
        unset($data['details']);
        
        // Update bill outward
        $billOutward->update($data);
        
        // Delete existing details
        $billOutward->details()->delete();
        
        // Create new bill outward details
        foreach ($details as $detail) {
            // Ensure either material_id or work_id is set
            if (empty($detail['material_id']) && empty($detail['work_id'])) {
                continue; // Skip if neither is set
            }
            
            BillOutwardDetail::create([
                'bill_outward_id' => $billOutward->id,
                'material_id' => $detail['material_id'] ?? null,
                'work_id' => $detail['work_id'] ?? null,
                'quantity' => $detail['quantity'],
                'unit' => $detail['unit'],
                'rate' => $detail['rate'],
                'amount' => $detail['amount'] ?? ($detail['quantity'] * $detail['rate']),
                'gst_percentage' => $detail['gst_percentage'] ?? 0,
                'sub_total' => $detail['sub_total'] ?? 0,
            ]);
        }
        
        return redirect()->route('bill-outwards.index')->with('success', 'Bill outward updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillOutward $billOutward)
    {
        // Delete file if exists
        if ($billOutward->bill_attachment) {
            $filePath = str_replace(asset(''), '', $billOutward->bill_attachment);
            $filePath = ltrim($filePath, '/');
            if (file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
        }
        
        $billOutward->details()->delete();
        $billOutward->delete();
        return redirect()->route('bill-outwards.index')->with('success', 'Bill outward deleted successfully.');
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
                'address' => $party->address,
            ]);
        }
        return response()->json(['gst' => '', 'address' => '']);
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

    /**
     * Get works by party locations
     */
    public function getWorksByParty(Request $request)
    {
        $partyId = $request->get('party_id');
        $party = Party::with('locations')->find($partyId);
        
        if ($party && $party->locations) {
            $locationIds = $party->locations->pluck('id');
            $works = Work::whereIn('location_id', $locationIds)
                ->orderBy('name_of_work')
                ->get(['id', 'name_of_work']);
            
            return response()->json($works);
        }
        
        return response()->json([]);
    }
}
