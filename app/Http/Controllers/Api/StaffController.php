<?php

namespace App\Http\Controllers\Api;

use App\Models\Staff;
use App\Models\User;
use App\Http\Resources\StaffResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * API counterpart of the web StaffController.
 *
 * Follows the established TEMPLATE:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web StaffStoreRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 *
 * Staff is LocationScoped: index() uses Staff::forCurrentUser() so staff only
 * see rows for their assigned locations.
 */
class StaffController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('staff');
    }

    public function index(Request $request): JsonResponse
    {
        $staff = Staff::forCurrentUser()->with('user', 'locations')->latest()->get();

        return $this->ok(StaffResource::collection($staff));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'role_id' => ['nullable', 'integer', 'exists:roles,id'],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'doj' => 'nullable|date',
            'designation' => 'nullable|string|max:255',
            'location_ids' => 'nullable|array',
            'location_ids.*' => 'exists:locations,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'permanent_address' => 'nullable|string',
            'present_address' => 'nullable|string',
            'mobile_number' => 'nullable|string|max:20',
            'other_contact_number' => 'nullable|string|max:20',
            'relative_name' => 'nullable|string|max:255',
            'relation' => 'nullable|string|max:255',
            'relative_mobile_no' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Other',
            'marital_status' => 'nullable|in:Single,Married,Divorced,Widowed',
            'blood_group' => 'nullable|string|max:10',
            'aadhar_no' => 'nullable|string|max:20',
            'pan_no' => 'nullable|string|max:20',
            'uan_no' => 'nullable|string|max:50',
            'esic_no' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
            'date_of_leaving' => 'nullable|date',
            'no_of_years_service' => 'nullable|integer',
            'remark' => 'nullable|string',
            'rate_per_day' => 'nullable|numeric|min:0',
            'rate_per_month' => 'nullable|numeric|min:0',
            'salary_date' => 'nullable|date',
        ]);

        $data['created_by'] = Auth::id();
        $email = $data['email'];
        unset($data['email']);
        $roleId = $data['role_id'] ?? null;
        unset($data['role_id']);
        $locationIds = $request->input('location_ids', []);
        unset($data['location_ids']);

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

        $staff = DB::transaction(function () use ($data, $email, $locationIds, $roleId) {
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

            return $staff;
        });

        $staff->load('user', 'locations');

        return $this->ok(new StaffResource($staff), 'Staff created.', 201);
    }

    public function show(Staff $staff): JsonResponse
    {
        $staff->load('user', 'locations');

        return $this->ok(new StaffResource($staff));
    }

    public function update(Request $request, Staff $staff): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($staff->user_id)],
            'role_id' => ['nullable', 'integer', 'exists:roles,id'],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'doj' => 'nullable|date',
            'designation' => 'nullable|string|max:255',
            'location_ids' => 'nullable|array',
            'location_ids.*' => 'exists:locations,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'permanent_address' => 'nullable|string',
            'present_address' => 'nullable|string',
            'mobile_number' => 'nullable|string|max:20',
            'other_contact_number' => 'nullable|string|max:20',
            'relative_name' => 'nullable|string|max:255',
            'relation' => 'nullable|string|max:255',
            'relative_mobile_no' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Other',
            'marital_status' => 'nullable|in:Single,Married,Divorced,Widowed',
            'blood_group' => 'nullable|string|max:10',
            'aadhar_no' => 'nullable|string|max:20',
            'pan_no' => 'nullable|string|max:20',
            'uan_no' => 'nullable|string|max:50',
            'esic_no' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
            'date_of_leaving' => 'nullable|date',
            'no_of_years_service' => 'nullable|integer',
            'remark' => 'nullable|string',
            'rate_per_day' => 'nullable|numeric|min:0',
            'rate_per_month' => 'nullable|numeric|min:0',
            'salary_date' => 'nullable|date',
        ]);

        $data['updated_by'] = Auth::id();
        $email = $data['email'];
        unset($data['email']);
        $roleId = $data['role_id'] ?? null;
        unset($data['role_id']);
        $locationIds = $request->input('location_ids', []);
        unset($data['location_ids']);

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

        $staff->load('user', 'locations');

        return $this->ok(new StaffResource($staff), 'Staff updated.');
    }

    public function destroy(Staff $staff): JsonResponse
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

        return $this->ok(null, 'Staff deleted.');
    }
}
