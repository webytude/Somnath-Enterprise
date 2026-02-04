<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Staff;
use App\Models\Location;
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
        $staff = Staff::orderBy('first_name')->get();
        
        // Get attendance for the selected date
        $attendances = Attendance::whereDate('attendance_date', $selectedDate)
            ->get()
            ->keyBy('staff_id');
        
        // Get all locations for attendance assignment
        $locations = Location::orderBy('name')->get();
        
        return view('admin.staff.attendance', compact('staff', 'attendances', 'selectedDate', 'locations'));
    }

    /**
     * Update attendance for a staff member
     */
    public function update(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'date' => 'required|date',
            'attendance_status' => 'required|in:absent,present,present_with_bike',
            'overtime_hours' => 'nullable|numeric|min:0|max:24',
            'location_id' => 'nullable|exists:locations,id',
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
                'attendance_status' => $request->attendance_status,
                'overtime_hours' => $request->overtime_hours ?? 0,
                'location_id' => $request->location_id,
                'updated_by' => Auth::id(),
                'created_by' => Auth::id(),
            ]
        );

        // Load location relationship for response
        $attendance->load('location');
        
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
            ->get()
            ->mapWithKeys(function ($attendance) {
                return [$attendance->attendance_date->format('Y-m-d') => [
                    'status' => $attendance->attendance_status,
                    'overtime_hours' => $attendance->overtime_hours
                ]];
            })
            ->toArray();

        return response()->json($attendances);
    }

    /**
     * Show all staff attendance report for all days
     */
    public function report(Request $request)
    {
        // Get filter parameters
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $staffId = $request->get('staff_id');
        
        // Parse dates
        $startDateParsed = Carbon::parse($startDate);
        $endDateParsed = Carbon::parse($endDate);
        
        // Get all staff
        $allStaff = Staff::orderBy('first_name')->get();
        
        // Build query
        $query = Attendance::with(['staff', 'location'])
            ->whereBetween('attendance_date', [$startDateParsed, $endDateParsed])
            ->orderBy('attendance_date', 'desc')
            ->orderBy('staff_id');
        
        // Filter by staff if selected
        if ($staffId) {
            $query->where('staff_id', $staffId);
        }
        
        $attendances = $query->get();
        
        // Get statistics
        $totalRecords = $attendances->count();
        $presentCount = $attendances->whereIn('attendance_status', ['present', 'present_with_bike'])->count();
        $absentCount = $attendances->where('attendance_status', 'absent')->count();
        $totalOvertimeHours = $attendances->sum('overtime_hours');
        
        return view('admin.attendance.report', compact(
            'attendances',
            'allStaff',
            'startDate',
            'endDate',
            'staffId',
            'totalRecords',
            'presentCount',
            'absentCount',
            'totalOvertimeHours'
        ));
    }
}
