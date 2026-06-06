<?php

namespace App\Http\Controllers\Api;

use App\Models\BillInward;
use App\Models\BillInwardDetail;
use App\Models\Party;
use App\Http\Resources\BillInwardResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * API counterpart of the web BillInwardController.
 *
 * Mirrors the established API template (see DepartmentController):
 *   - JSON in / JSON out
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors BillInwardStoreRequest)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 *
 * This model is LocationScoped, so index() uses forCurrentUser().
 * It has child/detail rows, replicated inside a DB::transaction.
 */
class BillInwardController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('bill-inwards');
    }

    public function index(Request $request): JsonResponse
    {
        $billInwards = BillInward::forCurrentUser()
            ->with(['firm', 'party', 'details.material'])
            ->latest()
            ->get();

        return $this->ok(BillInwardResource::collection($billInwards));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'firm_id' => 'required|exists:firms,id',
            'party_id' => 'required|exists:parties,id',
            'bill_number' => 'nullable|string|max:255',
            'bill_date' => 'nullable|date',
            'bill_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'add_bhadu_labour' => 'nullable|numeric|min:0',
            'total_bill_amount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'payment_status' => 'required|in:Pending,Paid',
            'payment_ref_number' => 'nullable|string|max:255|required_if:payment_status,Paid',
            'payment_date' => 'nullable|date|required_if:payment_status,Paid',
            'payment_remarks' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.material_id' => 'required|exists:material_lists,id',
            'details.*.quantity' => 'required|numeric|min:0',
            'details.*.unit' => 'required|string|max:50',
            'details.*.rate' => 'required|numeric|min:0',
            'details.*.amount' => 'nullable|numeric|min:0',
            'details.*.gst_percentage' => 'nullable|numeric|in:0,5,18',
            'details.*.sub_total' => 'nullable|numeric|min:0',
        ]);

        $data['created_by'] = Auth::id();

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

        $billInward = DB::transaction(function () use ($data, $details) {
            $billInward = BillInward::create($data);

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

            return $billInward;
        });

        $billInward->load(['firm', 'party', 'details.material']);

        return $this->ok(new BillInwardResource($billInward), 'Bill inward created successfully.', 201);
    }

    public function show(BillInward $billInward): JsonResponse
    {
        $billInward->load(['firm', 'party', 'details.material']);

        return $this->ok(new BillInwardResource($billInward));
    }

    public function update(Request $request, BillInward $billInward): JsonResponse
    {
        $data = $request->validate([
            'firm_id' => 'required|exists:firms,id',
            'party_id' => 'required|exists:parties,id',
            'bill_number' => 'nullable|string|max:255',
            'bill_date' => 'nullable|date',
            'bill_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'add_bhadu_labour' => 'nullable|numeric|min:0',
            'total_bill_amount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'payment_status' => 'required|in:Pending,Paid',
            'payment_ref_number' => 'nullable|string|max:255|required_if:payment_status,Paid',
            'payment_date' => 'nullable|date|required_if:payment_status,Paid',
            'payment_remarks' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.material_id' => 'required|exists:material_lists,id',
            'details.*.quantity' => 'required|numeric|min:0',
            'details.*.unit' => 'required|string|max:50',
            'details.*.rate' => 'required|numeric|min:0',
            'details.*.amount' => 'nullable|numeric|min:0',
            'details.*.gst_percentage' => 'nullable|numeric|in:0,5,18',
            'details.*.sub_total' => 'nullable|numeric|min:0',
        ]);

        $data['updated_by'] = Auth::id();

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

        DB::transaction(function () use ($billInward, $data, $details) {
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
        });

        $billInward->load(['firm', 'party', 'details.material']);

        return $this->ok(new BillInwardResource($billInward), 'Bill inward updated successfully.');
    }

    public function destroy(BillInward $billInward): JsonResponse
    {
        // Delete file if exists
        if ($billInward->bill_attachment) {
            $filePath = str_replace(asset(''), '', $billInward->bill_attachment);
            $filePath = ltrim($filePath, '/');
            if (file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
        }

        DB::transaction(function () use ($billInward) {
            $billInward->details()->delete();
            $billInward->delete();
        });

        return $this->ok(null, 'Bill inward deleted successfully.');
    }
}
