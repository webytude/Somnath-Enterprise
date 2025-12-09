<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Get attendance for a specific date range
     */
    public function index(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        $selectedDate = Carbon::parse($date);
        
        // Get all staff
        $staff = Staff::orderBy('name')->get();
        
        // Get attendance for the selected date
        $attendances = Attendance::whereDate('attendance_date', $selectedDate)
            ->pluck('is_present', 'staff_id')
            ->toArray();
        
        return view('admin.staff.attendance', compact('staff', 'attendances', 'selectedDate'));
    }

    /**
     * Update attendance for a staff member
     */
    public function update(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'date' => 'required|date',
            'is_present' => 'required|boolean',
        ]);

        $date = Carbon::parse($request->date);
        $today = Carbon::today();

        // Only allow updating attendance for current date
        if (!$date->isSameDay($today)) {
            return response()->json([
                'success' => false,
                'message' => 'You can only update attendance for today\'s date.'
            ], 403);
        }

        $attendance = Attendance::updateOrCreate(
            [
                'staff_id' => $request->staff_id,
                'attendance_date' => $date->format('Y-m-d'),
            ],
            [
                'is_present' => $request->is_present,
                'updated_by' => Auth::id(),
                'created_by' => Auth::id(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Attendance updated successfully.',
            'attendance' => $attendance
        ]);
    }

    /**
     * Get attendance data for calendar view
     */
    public function getAttendance(Request $request)
    {
        $staffId = $request->get('staff_id');
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $attendances = Attendance::where('staff_id', $staffId)
            ->whereBetween('attendance_date', [$startDate, $endDate])
            ->pluck('is_present', 'attendance_date')
            ->toArray();

        return response()->json($attendances);
    }
}
