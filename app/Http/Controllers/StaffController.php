<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StaffStoreRequest;
use Carbon\Carbon;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = Staff::latest()->get();
        
        // Get today's attendance
        $today = \Carbon\Carbon::today();
        $attendances = \App\Models\Attendance::whereDate('attendance_date', $today)
            ->get()
            ->keyBy('staff_id');
        
        // Get present employee count (present or present_with_bike)
        $presentCount = \App\Models\Attendance::whereDate('attendance_date', $today)
            ->whereIn('attendance_status', ['present', 'present_with_bike'])
            ->count();
        
        // Get present employees for payment
        $presentStaffIds = \App\Models\Attendance::whereDate('attendance_date', $today)
            ->whereIn('attendance_status', ['present', 'present_with_bike'])
            ->pluck('staff_id')
            ->toArray();
        
        $presentStaff = Staff::whereIn('id', $presentStaffIds)
            ->orderBy('first_name')
            ->get();
        
        // Get daily expenses - all for admin, only own for staff
        $dailyExpenses = collect();
        if (Auth::check()) {
            if (Auth::user()->isStaff() && Auth::user()->staff) {
                // Staff can only see their own expenses
                $dailyExpenses = \App\Models\DailyExpense::with('staff')
                    ->where('staff_id', Auth::user()->staff->id)
                    ->latest('date')
                    ->latest()
                    ->get();
            } else {
                // Admin can see all expenses
                $dailyExpenses = \App\Models\DailyExpense::with('staff')
                    ->latest('date')
                    ->latest()
                    ->get();
            }
        }
        
        // Get all locations for attendance assignment
        $locations = \App\Models\Location::orderBy('name')->get();
        
        return view('admin.staff.index', compact('staff', 'attendances', 'today', 'presentCount', 'presentStaff', 'dailyExpenses', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StaffStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        
        // Generate staff code if not provided
        if (empty($data['code'])) {
            $data['code'] = 'STF' . str_pad(Staff::count() + 1, 4, '0', STR_PAD_LEFT);
        }
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path() . '/images/staff', $name);
            $data['photo'] = asset('/images/staff/' . $name);
        }
        
        Staff::create($data);
        
        return redirect()->route('staff.index')->with('success', 'Staff created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        return view('admin.staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StaffStoreRequest $request, Staff $staff)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($staff->photo) {
                $oldPhotoPath = str_replace(asset(''), '', $staff->photo);
                $oldPhotoPath = ltrim($oldPhotoPath, '/');
                if (file_exists(public_path($oldPhotoPath))) {
                    unlink(public_path($oldPhotoPath));
                }
            }
            
            $image = $request->file('photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path() . '/images/staff', $name);
            $data['photo'] = asset('/images/staff/' . $name);
        }
        
        $staff->update($data);
        
        return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        // Delete photo if exists
        if ($staff->photo) {
            $photoPath = str_replace(asset(''), '', $staff->photo);
            $photoPath = ltrim($photoPath, '/');
            if (file_exists(public_path($photoPath))) {
                unlink(public_path($photoPath));
            }
        }
        
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
    }
}
