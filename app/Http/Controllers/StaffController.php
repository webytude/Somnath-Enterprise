<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Role;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StaffStoreRequest;
use Carbon\Carbon;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get selected date from request, default to today
        $selectedDate = $request->get('attendance_date', date('Y-m-d'));
        $today = \Carbon\Carbon::parse($selectedDate);
        $isToday = $today->isToday();

        // Staff list - admin sees all, staff sees only those sharing their locations.
        $staff = Staff::forCurrentUser()->latest()->get();
        $allowedStaffIds = $staff->pluck('id')->toArray();

        // Logged-in staff's own location ids, reused below to scope the locations dropdown.
        $staffLocationIds = [];
        if (Auth::check() && Auth::user()->isStaff() && Auth::user()->staff) {
            $staffLocationIds = Auth::user()->staff
                ->locations()
                ->pluck('locations.id')
                ->toArray();
        }

        // Get attendance for selected date (scoped to allowed staff)
        $attendances = \App\Models\Attendance::whereDate('attendance_date', $today)
            ->whereIn('staff_id', $allowedStaffIds)
            ->get()
            ->keyBy('staff_id');

        // Get present employee count (present or present_with_bike)
        $presentCount = \App\Models\Attendance::whereDate('attendance_date', $today)
            ->whereIn('attendance_status', ['present', 'present_with_bike'])
            ->whereIn('staff_id', $allowedStaffIds)
            ->count();

        // Get present employees for payment
        $presentStaffIds = \App\Models\Attendance::whereDate('attendance_date', $today)
            ->whereIn('attendance_status', ['present', 'present_with_bike'])
            ->whereIn('staff_id', $allowedStaffIds)
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
        
        // Get locations for attendance assignment - admin sees all, staff sees only their own
        $locationsQuery = \App\Models\Location::orderBy('name');
        if (Auth::check() && Auth::user()->isStaff() && Auth::user()->staff) {
            $locationsQuery->whereIn('id', $staffLocationIds);
        }
        $locations = $locationsQuery->get();
        
        // Check if attendance tab should be active (if attendance_date parameter is present)
        $activeTab = $request->has('attendance_date') ? 'attendance' : 'staff_list';
        
        return view('admin.staff.index', compact('staff', 'attendances', 'today', 'isToday', 'presentCount', 'presentStaff', 'dailyExpenses', 'locations', 'selectedDate', 'activeTab'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();

        return view('admin.staff.create', compact('locations', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StaffStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        $email = $data['email'];
        unset($data['email']);
        $roleId = $data['role_id'] ?? null;
        unset($data['role_id']);
        $locationIds = $request->input('location_ids', []);
        
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
        
        DB::transaction(function () use ($data, $email, $locationIds, $roleId) {
            $password = !empty($data['mobile_number']) && strlen((string)$data['mobile_number']) >= 6
                ? (string)$data['mobile_number']
                : 'password123@';

            $user = User::create([
                'name' => trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')),
                'email' => $email,
                'password' => Hash::make($password),
                'is_staff' => true,
                'role_id' => $roleId,
                'phone' => $data['mobile_number'] ?? null,
                'dob' => $data['dob'] ?? null,
                'address' => $data['present_address'] ?? null,
            ]);

            $data['user_id'] = $user->id;
            $staff = Staff::create($data);
            $staff->locations()->sync($locationIds);
        });
        
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
        $staff->load('locations', 'user');
        $locations = Location::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();

        return view('admin.staff.edit', compact('staff', 'locations', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StaffStoreRequest $request, Staff $staff)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        $email = $data['email'];
        unset($data['email']);
        $roleId = $data['role_id'] ?? null;
        unset($data['role_id']);
        $locationIds = $request->input('location_ids', []);
        
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
        
        DB::transaction(function () use ($staff, $data, $email, $locationIds, $roleId) {
            if ($staff->user) {
                $staff->user->update([
                    'name' => trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')),
                    'email' => $email,
                    'is_staff' => true,
                    'role_id' => $roleId,
                    'phone' => $data['mobile_number'] ?? null,
                    'dob' => $data['dob'] ?? null,
                    'address' => $data['present_address'] ?? null,
                ]);
                $data['user_id'] = $staff->user->id;
            } else {
                $password = !empty($data['mobile_number']) && strlen((string)$data['mobile_number']) >= 6
                    ? (string)$data['mobile_number']
                    : 'staff123';

                $user = User::create([
                    'name' => trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')),
                    'email' => $email,
                    'password' => Hash::make($password),
                    'is_staff' => true,
                    'role_id' => $roleId,
                    'phone' => $data['mobile_number'] ?? null,
                    'dob' => $data['dob'] ?? null,
                    'address' => $data['present_address'] ?? null,
                ]);
                $data['user_id'] = $user->id;
            }

            $staff->update($data);
            $staff->locations()->sync($locationIds);
        });
        
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
