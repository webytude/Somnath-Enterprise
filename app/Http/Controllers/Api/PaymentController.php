<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use App\Models\WorkOrder;
use App\Models\BillInward;
use App\Models\MaterialInward;
use App\Http\Resources\PaymentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web PaymentController.
 *
 * Follows the standard module API template:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web PaymentStoreRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 */
class PaymentController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('payments');
    }

    public function index(Request $request): JsonResponse
    {
        $payments = Payment::with(['staff', 'party', 'vendor', 'workOrder'])
            ->latest()
            ->get();

        return $this->ok(PaymentResource::collection($payments));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validatePayment($request);
        $data['created_by'] = Auth::id();
        $materialInwardIds = array_values($request->input('material_inward_ids', []));

        // material_inward_ids are used only for UI/amount calculation, do not persist.
        unset($data['material_inward_ids']);

        if (($data['payment_type'] ?? null) !== 'vendor') {
            unset($data['work_order_id']);
        }

        if (($data['payment_type'] ?? null) === 'vendor' && ! empty($data['work_order_id']) && empty($data['reason_bill_no'])) {
            $wo = WorkOrder::query()->find($data['work_order_id']);
            if ($wo) {
                $data['reason_bill_no'] = $wo->work_order_number;
            }
        }

        // Vendor: save TDS as total_deduction for records; paid_amount matches amount_payable (do not net off TDS).
        if (($data['payment_type'] ?? null) === 'vendor') {
            $tdsPct = isset($data['tds_percentage']) ? (float) $data['tds_percentage'] : 0;
            $data['total_deduction'] = round(($data['amount_payable'] * $tdsPct) / 100, 2);
            $data['paid_amount'] = $data['amount_payable'];
        }

        $payment = Payment::create($data);

        if ($payment->payment_type === 'vendor' && $payment->work_order_id) {
            $payment->workOrder?->syncVendorPaidTotalFromPayments();
        }

        // Update bill status if this is a party payment with a bill number
        if ($data['payment_type'] === 'party' && !empty($data['reason_bill_no']) && !empty($data['party_id'])) {
            $bill = BillInward::where('party_id', $data['party_id'])
                ->where('bill_number', $data['reason_bill_no'])
                ->first();

            if ($bill) {
                $totalPaid = Payment::where('party_id', $data['party_id'])
                    ->where('payment_type', 'party')
                    ->where('reason_bill_no', $data['reason_bill_no'])
                    ->sum('paid_amount');

                $paymentStatus = ($totalPaid >= (float)$bill->total_bill_amount) ? 'Paid' : 'Pending';

                $bill->update([
                    'payment_status' => $paymentStatus,
                    'payment_ref_number' => $data['ref_number'] ?? null,
                    'payment_date' => $data['payment_date'] ?? null,
                    'payment_remarks' => $data['remarks'] ?? null,
                    'updated_by' => Auth::id(),
                ]);
            }
        }

        // Update selected material inward status for party payments.
        if (
            $data['payment_type'] === 'party' &&
            !empty($data['party_id']) &&
            !empty($materialInwardIds)
        ) {
            MaterialInward::where('party_id', $data['party_id'])
                ->whereIn('id', $materialInwardIds)
                ->update([
                    'payment_status' => 'Paid',
                    'payment_ref_number' => $data['ref_number'] ?? null,
                    'payment_date' => $data['payment_date'] ?? null,
                    'payment_remarks' => $data['remarks'] ?? null,
                    'updated_by' => Auth::id(),
                ]);
        }

        return $this->ok(new PaymentResource($payment), 'Payment created successfully.', 201);
    }

    public function show(Payment $payment): JsonResponse
    {
        $payment->load(['staff', 'party', 'vendor', 'workOrder', 'creator', 'updater']);

        return $this->ok(new PaymentResource($payment));
    }

    public function update(Request $request, Payment $payment): JsonResponse
    {
        $data = $this->validatePayment($request);
        $data['updated_by'] = Auth::id();
        $materialInwardIds = array_values($request->input('material_inward_ids', []));

        // material_inward_ids are used only for UI/amount calculation, do not persist.
        unset($data['material_inward_ids']);

        if (($data['payment_type'] ?? null) !== 'vendor') {
            unset($data['work_order_id']);
        }

        $workOrderIdsToSync = [];
        if ($payment->payment_type === 'vendor' && $payment->work_order_id) {
            $workOrderIdsToSync[] = (int) $payment->work_order_id;
        }

        if (($data['payment_type'] ?? null) === 'vendor' && ! empty($data['work_order_id']) && empty($data['reason_bill_no'])) {
            $wo = WorkOrder::query()->find($data['work_order_id']);
            if ($wo) {
                $data['reason_bill_no'] = $wo->work_order_number;
            }
        }

        // Vendor: save TDS as total_deduction for records; paid_amount matches amount_payable (do not net off TDS).
        if (($data['payment_type'] ?? null) === 'vendor') {
            $tdsPct = isset($data['tds_percentage']) ? (float) $data['tds_percentage'] : 0;
            $data['total_deduction'] = round(($data['amount_payable'] * $tdsPct) / 100, 2);
            $data['paid_amount'] = $data['amount_payable'];
        }

        $payment->update($data);

        $fresh = $payment->fresh();
        if ($fresh->payment_type === 'vendor' && $fresh->work_order_id) {
            $workOrderIdsToSync[] = (int) $fresh->work_order_id;
        }
        foreach (array_unique(array_filter($workOrderIdsToSync)) as $woId) {
            WorkOrder::query()->find($woId)?->syncVendorPaidTotalFromPayments();
        }

        // Update bill status if this is a party payment with a bill number
        if ($data['payment_type'] === 'party' && !empty($data['reason_bill_no']) && !empty($data['party_id'])) {
            $bill = BillInward::where('party_id', $data['party_id'])
                ->where('bill_number', $data['reason_bill_no'])
                ->first();

            if ($bill) {
                $totalPaid = Payment::where('party_id', $data['party_id'])
                    ->where('payment_type', 'party')
                    ->where('reason_bill_no', $data['reason_bill_no'])
                    ->sum('paid_amount');

                $paymentStatus = ($totalPaid >= (float)$bill->total_bill_amount) ? 'Paid' : 'Pending';

                $bill->update([
                    'payment_status' => $paymentStatus,
                    'payment_ref_number' => $data['ref_number'] ?? null,
                    'payment_date' => $data['payment_date'] ?? null,
                    'payment_remarks' => $data['remarks'] ?? null,
                    'updated_by' => Auth::id(),
                ]);
            }
        }

        // Update selected material inward status for party payments.
        if (
            $data['payment_type'] === 'party' &&
            !empty($data['party_id']) &&
            !empty($materialInwardIds)
        ) {
            MaterialInward::where('party_id', $data['party_id'])
                ->whereIn('id', $materialInwardIds)
                ->update([
                    'payment_status' => 'Paid',
                    'payment_ref_number' => $data['ref_number'] ?? null,
                    'payment_date' => $data['payment_date'] ?? null,
                    'payment_remarks' => $data['remarks'] ?? null,
                    'updated_by' => Auth::id(),
                ]);
        }

        return $this->ok(new PaymentResource($payment), 'Payment updated successfully.');
    }

    public function destroy(Payment $payment): JsonResponse
    {
        $woId = $payment->payment_type === 'vendor' ? $payment->work_order_id : null;
        $payment->delete();
        if ($woId) {
            WorkOrder::query()->find($woId)?->syncVendorPaidTotalFromPayments();
        }

        return $this->ok(null, 'Payment deleted successfully.');
    }

    /**
     * Inline validation mirroring App\Http\Requests\PaymentStoreRequest.
     */
    private function validatePayment(Request $request): array
    {
        $paymentType = $request->input('payment_type');

        $rules = [
            'payment_type' => 'required|in:staff,party,vendor',
            'payment_date' => 'required|date',
            'amount_payable' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'ref_number' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'tds_percentage' => 'nullable|numeric|min:0|max:100',
            'total_deduction' => 'nullable|numeric|min:0',
        ];

        // Staff payment validation
        if ($paymentType === 'staff') {
            $rules['staff_id'] = 'required|exists:staff,id';
            $rules['salary_payable'] = 'nullable|numeric|min:0';
            $rules['expense_payable'] = 'nullable|numeric|min:0';
            $rules['total_payable'] = 'nullable|numeric|min:0';
            $rules['reason_of_payment'] = 'nullable|string|max:255';
        }

        // Party payment validation
        if ($paymentType === 'party') {
            $rules['party_id'] = 'required|exists:parties,id';
            $rules['material_inward_ids'] = 'nullable|array';
            $rules['material_inward_ids.*'] = 'integer|exists:material_inwards,id';
            $rules['reason_bill_no'] = 'nullable|string|max:255';
            $rules['bill_payable'] = 'nullable|numeric|min:0';
        }

        // Vendor payment validation
        if ($paymentType === 'vendor') {
            $rules['vendor_id'] = 'required|exists:contractors,id';
            $rules['work_order_id'] = 'required|exists:work_orders,id';
            $rules['reason_bill_no'] = 'nullable|string|max:255';
            $rules['bill_payable'] = 'nullable|numeric|min:0';
        }

        return $request->validate($rules);
    }
}
