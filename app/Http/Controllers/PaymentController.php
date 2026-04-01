<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Staff;
use App\Models\Party;
use App\Models\Contractor;
use App\Models\BillInward;
use App\Models\DailyExpense;
use App\Models\MaterialInward;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaymentStoreRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with(['staff', 'party', 'vendor', 'workOrder'])
            ->latest()
            ->get();
        
        return view('admin.payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $staff = Staff::orderBy('first_name')->get();
        $parties = Party::orderBy('name')->get();
        $vendors = Contractor::orderBy('pedhi')->get();
        
        return view('admin.payment.create', compact('staff', 'parties', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
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
        
        // Calculate total deduction and paid amount for vendor
        if ($data['payment_type'] === 'vendor' && isset($data['tds_percentage'])) {
            $tdsAmount = ($data['amount_payable'] * $data['tds_percentage']) / 100;
            $data['total_deduction'] = $tdsAmount;
            $data['paid_amount'] = $data['amount_payable'] - $tdsAmount;
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
                // Calculate total paid amount for this bill (payment already created, so it's included)
                $totalPaid = Payment::where('party_id', $data['party_id'])
                    ->where('payment_type', 'party')
                    ->where('reason_bill_no', $data['reason_bill_no'])
                    ->sum('paid_amount');
                
                // Only mark as 'Paid' if total paid >= bill amount
                $paymentStatus = ($totalPaid >= (float)$bill->total_bill_amount) ? 'Paid' : 'Pending';
                
                $bill->update([
                    'payment_status' => $paymentStatus,
                    'payment_ref_number' => $data['ref_number'] ?? null,
                    'payment_date' => $data['payment_date'] ?? null,
                    'payment_remarks' => $data['remarks'] ?? null,
                    'updated_by' => Auth::user()->id,
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
                    'updated_by' => Auth::user()->id,
                ]);
        }
        
        return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load(['staff', 'party', 'vendor', 'workOrder', 'creator', 'updater']);
        return view('admin.payment.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $staff = Staff::orderBy('first_name')->get();
        $parties = Party::orderBy('name')->get();
        $vendors = Contractor::orderBy('pedhi')->get();
        
        return view('admin.payment.edit', compact('payment', 'staff', 'parties', 'vendors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentStoreRequest $request, Payment $payment)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
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
        
        // Calculate total deduction and paid amount for vendor
        if ($data['payment_type'] === 'vendor' && isset($data['tds_percentage'])) {
            $tdsAmount = ($data['amount_payable'] * $data['tds_percentage']) / 100;
            $data['total_deduction'] = $tdsAmount;
            $data['paid_amount'] = $data['amount_payable'] - $tdsAmount;
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
                // Calculate total paid amount for this bill (all payments including updated one)
                $totalPaid = Payment::where('party_id', $data['party_id'])
                    ->where('payment_type', 'party')
                    ->where('reason_bill_no', $data['reason_bill_no'])
                    ->sum('paid_amount');
                
                // Only mark as 'Paid' if total paid >= bill amount
                $paymentStatus = ($totalPaid >= (float)$bill->total_bill_amount) ? 'Paid' : 'Pending';
                
                $bill->update([
                    'payment_status' => $paymentStatus,
                    'payment_ref_number' => $data['ref_number'] ?? null,
                    'payment_date' => $data['payment_date'] ?? null,
                    'payment_remarks' => $data['remarks'] ?? null,
                    'updated_by' => Auth::user()->id,
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
                    'updated_by' => Auth::user()->id,
                ]);
        }
        
        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $woId = $payment->payment_type === 'vendor' ? $payment->work_order_id : null;
        $payment->delete();
        if ($woId) {
            WorkOrder::query()->find($woId)?->syncVendorPaidTotalFromPayments();
        }

        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }

    /**
     * Get staff salary and expense payable
     */
    public function getStaffPayable(Request $request)
    {
        $staffId = $request->get('staff_id');
        
        if (!$staffId) {
            return response()->json([
                'salary_payable' => 0,
                'expense_payable' => 0,
                'total_payable' => 0
            ]);
        }
        
        $staff = Staff::find($staffId);
        if (!$staff) {
            return response()->json([
                'salary_payable' => 0,
                'expense_payable' => 0,
                'total_payable' => 0
            ]);
        }
        
        // Calculate total salary and expense payable
        $salaryPayable = $staff->rate_per_month ?? 0;
        $expensePayable = DailyExpense::where('staff_id', $staffId)
            ->sum('amount');
        $totalPayable = $salaryPayable + $expensePayable;
        
        // Get all previous payments for this staff to exclude already paid amounts
        $totalPaidAmount = Payment::where('staff_id', $staffId)
            ->where('payment_type', 'staff')
            ->sum('paid_amount');
        
        // Calculate remaining payable (subtract already paid amounts)
        $remainingTotalPayable = max(0, $totalPayable - $totalPaidAmount);
        
        // Proportionally calculate remaining salary and expense
        if ($totalPayable > 0) {
            $salaryRatio = $salaryPayable / $totalPayable;
            $expenseRatio = $expensePayable / $totalPayable;
            $remainingSalaryPayable = max(0, $remainingTotalPayable * $salaryRatio);
            $remainingExpensePayable = max(0, $remainingTotalPayable * $expenseRatio);
        } else {
            $remainingSalaryPayable = 0;
            $remainingExpensePayable = 0;
        }
        
        return response()->json([
            'salary_payable' => number_format($remainingSalaryPayable, 2, '.', ''),
            'expense_payable' => number_format($remainingExpensePayable, 2, '.', ''),
            'total_payable' => number_format($remainingTotalPayable, 2, '.', '')
        ]);
    }

    /**
     * Get party bills payable
     */
    public function getPartyBills(Request $request)
    {
        $partyId = $request->get('party_id');
        
        if (!$partyId) {
            return response()->json(['bills' => []]);
        }
        
        // Get all bills for the party (both pending and paid, to handle partial payments)
        $allBills = BillInward::where('party_id', $partyId)
            ->orderBy('bill_date', 'desc')
            ->get(['id', 'bill_number', 'bill_date', 'total_bill_amount', 'payment_status']);
        
        // Get all payments for this party grouped by bill number
        $paymentsByBill = Payment::where('party_id', $partyId)
            ->where('payment_type', 'party')
            ->whereNotNull('reason_bill_no')
            ->selectRaw('reason_bill_no, SUM(paid_amount) as total_paid')
            ->groupBy('reason_bill_no')
            ->pluck('total_paid', 'reason_bill_no')
            ->toArray();
        
        // Calculate remaining amount for each bill
        $unpaidBills = $allBills->map(function($bill) use ($paymentsByBill) {
            $totalPaid = isset($paymentsByBill[$bill->bill_number]) ? (float)$paymentsByBill[$bill->bill_number] : 0;
            $remainingAmount = (float)$bill->total_bill_amount - $totalPaid;
            
            // Only include bills with remaining amount > 0
            if ($remainingAmount > 0) {
                return [
                    'id' => $bill->id,
                    'bill_number' => $bill->bill_number,
                    'bill_date' => $bill->bill_date,
                    'total_bill_amount' => $remainingAmount, // Return remaining amount, not full amount
                    'original_amount' => $bill->total_bill_amount,
                    'paid_amount' => $totalPaid,
                    'remaining_amount' => $remainingAmount
                ];
            }
            return null;
        })->filter(); // Remove null values
        
        $totalPayable = $unpaidBills->sum('remaining_amount');
        
        return response()->json([
            'bills' => $unpaidBills->values(),
            'total_payable' => number_format($totalPayable, 2, '.', '')
        ]);
    }

    /**
     * Get party-wise Material Inward bills (for party payments)
     */
    public function getPartyMaterialInwards(Request $request)
    {
        $partyId = $request->get('party_id');
        if (!$partyId) {
            return response()->json(['bills' => []]);
        }

        $inwardsQuery = MaterialInward::where('party_id', $partyId)
            ->where(function ($query) {
                $query->whereNull('payment_status')
                    ->orWhere('payment_status', 'Pending');
            })
            ->orderBy('bill_voucher_date', 'desc')
            ->select(['id', 'bill_voucher_number', 'bill_voucher_date', 'total_bill_voucher_amount']);

        $inwards = $inwardsQuery->get();

        return response()->json([
            'bills' => $inwards->map(function ($inward) {
                return [
                    'id' => $inward->id,
                    'bill_voucher_number' => $inward->bill_voucher_number,
                    'bill_voucher_date' => $inward->bill_voucher_date ? $inward->bill_voucher_date->format('d-m-Y') : null,
                    'total_bill_voucher_amount' => (float) $inward->total_bill_voucher_amount,
                ];
            })->values(),
        ]);
    }

    /**
     * Work orders for vendor payment (label: W.O. no. + subject; payable = remaining on WO).
     */
    public function getVendorBills(Request $request)
    {
        $vendorId = $request->get('vendor_id');
        $excludePaymentId = $request->get('payment_id');

        if (! $vendorId) {
            return response()->json(['work_orders' => [], 'total_payable' => '0.00']);
        }

        $orders = WorkOrder::query()
            ->where('contractor_id', $vendorId)
            ->orderByDesc('order_date')
            ->orderByDesc('id')
            ->get();

        $workOrders = $orders->map(function (WorkOrder $wo) use ($excludePaymentId) {
            $q = Payment::query()
                ->where('payment_type', 'vendor')
                ->where('work_order_id', $wo->id);
            if ($excludePaymentId) {
                $q->where('id', '!=', $excludePaymentId);
            }
            $paidTowards = (float) $q->sum('amount_payable');
            $total = (float) $wo->total_order_value;
            $remaining = round(max(0, $total - $paidTowards), 2);

            return [
                'id' => $wo->id,
                'label' => $wo->paymentSelectLabel(),
                'total_order_value' => $total,
                'paid_towards_order' => round($paidTowards, 2),
                'remaining' => $remaining,
                'bill_payable' => $remaining,
            ];
        })->values();

        $totalPayable = (float) $workOrders->sum('remaining');

        return response()->json([
            'work_orders' => $workOrders,
            'total_payable' => number_format($totalPayable, 2, '.', ''),
        ]);
    }
}
