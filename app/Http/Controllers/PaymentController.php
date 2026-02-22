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
        
        Payment::create($data);
        
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
        
        // Calculate salary payable (you can customize this logic)
        $salaryPayable = $staff->rate_per_month ?? 0;
        
        // Calculate expense payable from daily expenses
        // Note: Currently summing all expenses. If you want to track paid expenses, add payment_id column to daily_expenses table
        $expensePayable = DailyExpense::where('staff_id', $staffId)
            ->sum('amount');
        
        $totalPayable = $salaryPayable + $expensePayable;
        
        return response()->json([
            'salary_payable' => number_format($salaryPayable, 2, '.', ''),
            'expense_payable' => number_format($expensePayable, 2, '.', ''),
            'total_payable' => number_format($totalPayable, 2, '.', '')
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
        
        // Get pending bills for the party
        $bills = BillInward::where('party_id', $partyId)
            ->where('payment_status', 'Pending')
            ->orderBy('bill_date', 'desc')
            ->get(['id', 'bill_number', 'bill_date', 'total_bill_amount']);
        
        $totalPayable = $bills->sum('total_bill_amount');
        
        return response()->json([
            'bills' => $bills,
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
        
        // For now, return empty. You can add vendor bills logic later
        // This might come from Material Inward or other sources
        
        return response()->json([
            'bills' => [],
            'total_payable' => '0.00'
        ]);
    }
}
