<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $staffId = $this->route('staff') ? $this->route('staff')->id : null;
        
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'doj' => 'nullable|date',
            'designation' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'permanent_address' => 'nullable|string',
            'present_address' => 'nullable|string',
            'mobile_number' => 'nullable|string|max:20',
            'other_contact_number' => 'nullable|string|max:20',
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
        ];
    }
}
