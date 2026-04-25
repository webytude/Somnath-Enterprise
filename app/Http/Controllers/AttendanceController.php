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
        $staff = Staff::with('locations')->orderBy('first_name')->get();
        
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
            'attendance_status' => 'required|in:absent,present,present_with_bike,half_day',
            'location_id' => [
                'nullable',
                'exists:locations,id',
                function ($attribute, $value, $fail) use ($request) {
                    if (empty($value)) {
                        return;
                    }

                    $isMapped = \DB::table('staff_locations')
                        ->where('staff_id', $request->staff_id)
                        ->where('location_id', $value)
                        ->exists();

                    if (! $isMapped) {
                        $fail('Selected location is not assigned to this staff.');
                    }
                },
            ],
            'remark' => 'nullable|string|max:1000',
        ]);

        $date = Carbon::parse($request->date);
        
        // Check if attendance already exists for this date and staff
        $existingAttendance = Attendance::where('staff_id', $request->staff_id)
            ->whereDate('attendance_date', $date->format('Y-m-d'))
            ->first();
        
        // Prepare data for update or create
        $attendanceData = [
            'attendance_status' => $request->attendance_status,
            // Keep previous overtime value unchanged; OT is no longer captured from UI.
            'overtime_hours' => $existingAttendance?->overtime_hours ?? 0,
            'location_id' => $request->location_id,
            'remark' => $request->remark,
            'updated_by' => Auth::id(),
        ];
        
        // If it's a new record, set created_by. If updating, keep original created_by
        if (!$existingAttendance) {
            $attendanceData['created_by'] = Auth::id();
        }
        
        $attendance = Attendance::updateOrCreate(
            [
                'staff_id' => $request->staff_id,
                'attendance_date' => $date->format('Y-m-d'),
            ],
            $attendanceData
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
