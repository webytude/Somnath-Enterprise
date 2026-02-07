<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartyStoreRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'firm_id' => 'required|exists:firms,id',
            'gst' => 'nullable|string|max:50',
            'pancard' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'mobile' => 'nullable|string|max:20',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_mobile' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
            'list_of_material' => 'nullable|string',
            'bank_account_holder_name' => 'nullable|string|max:255',
            'bank_name_branch' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
            'material_ids' => 'nullable|array',
            'material_ids.*' => 'exists:material_lists,id',
            'location_ids' => 'nullable|array',
            'location_ids.*' => 'exists:locations,id',
        ];
    }
}
