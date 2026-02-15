<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractorStoreRequest extends FormRequest
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
            'pedhi' => 'nullable|string|max:255',
            'gst' => 'nullable|string|max:50',
            'pan' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:255',
            'ifsc' => 'nullable|string|max:20',
            'branch_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'mobile' => 'nullable|string|max:20',
            'contact_person' => 'nullable|string|max:255',
            'contact_person_mobile' => 'nullable|string|max:20',
            'ref_by' => 'nullable|string|max:255',
            'ref_cont_no' => 'nullable|string|max:255',
            'payment_term' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric|min:0',
            'remaining_amount' => 'nullable|numeric|min:0',
            'payment_slab_id' => 'nullable|exists:payment_slabs,id',
            'location_ids' => 'nullable|array',
            'location_ids.*' => 'exists:locations,id',
            'work_ids' => 'nullable|array',
            'work_ids.*' => 'exists:works,id',
        ];
    }
}
