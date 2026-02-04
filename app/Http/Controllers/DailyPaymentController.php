<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyPayment;
use App\Models\Staff;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DailyPaymentController extends Controller
{
    /**
     * Get daily payment view with present employees
     */
    public function index(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        $selectedDate = Carbon::parse($date);
        $today = Carbon::today();
        
        // Get present employees for today
        $presentStaffIds = Attendance::whereDate('attendance_date', $today)
            ->whereIn('attendance_status', ['present', 'present_with_bike'])
            ->pluck('staff_id')
            ->toArray();
        
        $presentStaff = Staff::whereIn('id', $presentStaffIds)
            ->orderBy('first_name')
            ->get();
        
        // Get payments for the selected date
        $payments = DailyPayment::whereDate('payment_date', $selectedDate)
            ->pluck('amount', 'staff_id')
            ->toArray();
        
        // Get payment details for today
        $paymentDetails = DailyPayment::whereDate('payment_date', $selectedDate)
            ->with('staff')
            ->get()
            ->keyBy('staff_id');
        
        return view('admin.staff.daily-payment', compact('presentStaff', 'payments', 'paymentDetails', 'selectedDate', 'today'));
    }

    /**
     * Store or update daily payment
     */
    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
            'remark' => 'nullable|string',
        ]);

        $date = Carbon::parse($request->payment_date);
        $today = Carbon::today();

        // Only allow payment for current date
        if (!$date->isSameDay($today)) {
            return response()->json([
                'success' => false,
                'message' => 'You can only make payments for today\'s date.'
            ], 403);
        }

        // Check if staff is present today
        $isPresent = Attendance::where('staff_id', $request->staff_id)
            ->whereDate('attendance_date', $today)
            ->whereIn('attendance_status', ['present', 'present_with_bike'])
            ->exists();

        if (!$isPresent) {
            return response()->json([
                'success' => false,
                'message' => 'Payment can only be made for employees who are present today.'
            ], 403);
        }

        $payment = DailyPayment::updateOrCreate(
            [
                'staff_id' => $request->staff_id,
                'payment_date' => $date->format('Y-m-d'),
            ],
            [
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'remark' => $request->remark,
                'updated_by' => Auth::id(),
                'created_by' => Auth::id(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Payment saved successfully.',
            'payment' => $payment->load('staff')
        ]);
    }

    /**
     * Get payment details for a staff member
     */
    public function getPayment(Request $request)
    {
        $staffId = $request->get('staff_id');
        $date = $request->get('date', date('Y-m-d'));

        $payment = DailyPayment::where('staff_id', $staffId)
            ->whereDate('payment_date', $date)
            ->first();

        return response()->json($payment);
    }

    /**
     * Delete payment
     */
    public function destroy(Request $request, $id)
    {
        $payment = DailyPayment::findOrFail($id);
        $date = Carbon::parse($payment->payment_date);
        $today = Carbon::today();

        // Only allow deletion for current date
        if (!$date->isSameDay($today)) {
            return response()->json([
                'success' => false,
                'message' => 'You can only delete payments for today\'s date.'
            ], 403);
        }

        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment deleted successfully.'
        ]);
    }
}
