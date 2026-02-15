<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialInwardStoreRequest extends FormRequest
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
            'location_id' => 'required|exists:locations,id',
            'work_id' => 'nullable|exists:works,id',
            'party_id' => 'required|exists:parties,id',
            'bill_voucher_type' => 'nullable|string|max:255',
            'bill_voucher_number' => 'nullable|string|max:255',
            'bill_voucher_date' => 'nullable|date',
            'material_inward_at_site_date' => 'nullable|date',
            'bill_voucher_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'add_bhadu' => 'nullable|numeric|min:0',
            'total_bill_voucher_amount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.material_id' => 'required|exists:material_lists,id',
            'details.*.make' => 'nullable|string|max:255',
            'details.*.quantity' => 'required|numeric|min:0',
            'details.*.unit' => 'required|string|max:50',
            'details.*.rate' => 'required|numeric|min:0',
            'details.*.amount' => 'nullable|numeric|min:0',
            'details.*.gst_percentage' => 'nullable|numeric|in:0,5,18',
            'details.*.sub_total' => 'nullable|numeric|min:0',
        ];
    }
}
