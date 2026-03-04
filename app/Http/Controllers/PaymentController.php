<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Staff;
use App\Models\Party;
use App\Models\Contractor;
use App\Models\BillInward;
use App\Models\DailyExpense;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaymentStoreRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with(['staff', 'party', 'vendor'])
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
        
        // Calculate total deduction and paid amount for vendor
        if ($data['payment_type'] === 'vendor' && isset($data['tds_percentage'])) {
            $tdsAmount = ($data['amount_payable'] * $data['tds_percentage']) / 100;
            $data['total_deduction'] = $tdsAmount;
            $data['paid_amount'] = $data['amount_payable'] - $tdsAmount;
        }
        
        $payment = Payment::create($data);
        
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
        
        return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load(['staff', 'party', 'vendor', 'creator', 'updater']);
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
        
        // Calculate total deduction and paid amount for vendor
        if ($data['payment_type'] === 'vendor' && isset($data['tds_percentage'])) {
            $tdsAmount = ($data['amount_payable'] * $data['tds_percentage']) / 100;
            $data['total_deduction'] = $tdsAmount;
            $data['paid_amount'] = $data['amount_payable'] - $tdsAmount;
        }
        
        $payment->update($data);
        
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
        
        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
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
     * Get vendor bills payable
     */
    public function getVendorBills(Request $request)
    {
        $vendorId = $request->get('vendor_id');
        
        if (!$vendorId) {
            return response()->json(['bills' => []]);
        }
        
        // Get all payments for this vendor to check which bills have been paid
        $paidPayments = Payment::where('vendor_id', $vendorId)
            ->where('payment_type', 'vendor')
            ->whereNotNull('reason_bill_no')
            ->pluck('reason_bill_no')
            ->toArray();
        
        // For vendors, bills might come from Material Inward or other sources
        // Since MaterialInward has party_id and vendors might not be directly linked,
        // we'll track via payments table - exclude bills that have already been paid
        
        // Calculate total payable from unpaid bills
        // If there are already payments for this vendor with bill numbers, exclude those bills
        $totalPayable = 0;
        
        // Note: If you have a vendor bills table or MaterialInward linked to vendors,
        // you can fetch bills here and filter out paid ones:
        // $bills = MaterialInward::where('vendor_id', $vendorId) // if such field exists
        //     ->whereNotIn('bill_voucher_number', $paidPayments)
        //     ->get();
        // $totalPayable = $bills->sum('total_bill_voucher_amount');
        
        // For now, return 0 to prevent showing already paid amounts
        // The key is that if a payment exists for this vendor with a reason_bill_no,
        // that bill won't be included in future calculations
        
        return response()->json([
            'bills' => [],
            'total_payable' => number_format($totalPayable, 2, '.', '')
        ]);
    }
}
