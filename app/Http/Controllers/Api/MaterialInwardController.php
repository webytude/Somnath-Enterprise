<?php

namespace App\Http\Controllers\Api;

use App\Models\MaterialInward;
use App\Models\MaterialInwardDetail;
use App\Models\Party;
use App\Http\Resources\MaterialInwardResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * API counterpart of the web MaterialInwardController.
 *
 * Mirrors the TEMPLATE (DepartmentController):
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors MaterialInwardStoreRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 *
 * MaterialInward is LocationScoped, so index() uses forCurrentUser().
 * This module has child/detail rows handled inside a DB transaction.
 */
class MaterialInwardController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('material-inwards');
    }

    public function index(Request $request): JsonResponse
    {
        $materialInwards = MaterialInward::forCurrentUser()
            ->with(['location', 'work', 'party', 'details.material'])
            ->latest()
            ->get();

        return $this->ok(MaterialInwardResource::collection($materialInwards));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'location_id' => 'required|exists:locations,id',
            'work_id' => 'nullable|exists:works,id',
            'party_id' => 'required|exists:parties,id',
            'bill_voucher_type' => 'nullable|string|max:255',
            'bill_voucher_number' => 'nullable|string|max:255',
            'bill_voucher_date' => 'nullable|date',
            'material_inward_at_site_date' => 'nullable|date',
            'bill_voucher_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'add_bhadu' => 'nullable|numeric|min:0',
            'total_bill_voucher_amount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.material_id' => 'required|exists:material_lists,id',
            'details.*.make' => 'nullable|string|max:255',
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
        if ($request->hasFile('bill_voucher_attachment')) {
            $file = $request->file('bill_voucher_attachment');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path() . '/images/material-inwards', $name);
            $data['bill_voucher_attachment'] = asset('/images/material-inwards/' . $name);
        }

        // Extract details from data
        $details = $data['details'] ?? [];
        unset($data['details']);

        $materialInward = DB::transaction(function () use ($data, $details) {
            $materialInward = MaterialInward::create($data);

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

            return $materialInward;
        });

        $materialInward->load(['location', 'work', 'party', 'details.material']);

        return $this->ok(new MaterialInwardResource($materialInward), 'Material inward created.', 201);
    }

    public function show(MaterialInward $materialInward): JsonResponse
    {
        $materialInward->load(['location', 'work', 'party', 'details.material']);

        return $this->ok(new MaterialInwardResource($materialInward));
    }

    public function update(Request $request, MaterialInward $materialInward): JsonResponse
    {
        $data = $request->validate([
            'location_id' => 'required|exists:locations,id',
            'work_id' => 'nullable|exists:works,id',
            'party_id' => 'required|exists:parties,id',
            'bill_voucher_type' => 'nullable|string|max:255',
            'bill_voucher_number' => 'nullable|string|max:255',
            'bill_voucher_date' => 'nullable|date',
            'material_inward_at_site_date' => 'nullable|date',
            'bill_voucher_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'add_bhadu' => 'nullable|numeric|min:0',
            'total_bill_voucher_amount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.material_id' => 'required|exists:material_lists,id',
            'details.*.make' => 'nullable|string|max:255',
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

        DB::transaction(function () use ($materialInward, $data, $details) {
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
        });

        $materialInward->load(['location', 'work', 'party', 'details.material']);

        return $this->ok(new MaterialInwardResource($materialInward), 'Material inward updated.');
    }

    public function destroy(MaterialInward $materialInward): JsonResponse
    {
        // Delete file if exists
        if ($materialInward->bill_voucher_attachment) {
            $filePath = str_replace(asset(''), '', $materialInward->bill_voucher_attachment);
            $filePath = ltrim($filePath, '/');
            if (file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
        }

        DB::transaction(function () use ($materialInward) {
            $materialInward->details()->delete();
            $materialInward->delete();
        });

        return $this->ok(null, 'Material inward deleted.');
    }
}
