<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillOutwardStoreRequest extends FormRequest
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
            'firm_id' => 'required|exists:firms,id',
            'bill_number' => 'nullable|string|max:255',
            'bill_date' => 'nullable|date',
            'bill_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'party_id' => 'required|exists:parties,id',
            'add_bhadu_labour' => 'nullable|numeric|min:0',
            'total_bill_amount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'payment_status' => 'required|in:Pending,Received',
            'sd_percentage' => 'nullable|numeric|min:0|max:100',
            'tds_percentage' => 'nullable|numeric|min:0|max:100',
            'gst_deduction_percentage' => 'nullable|numeric|min:0|max:100',
            'lc_percentage' => 'nullable|numeric|min:0|max:100',
            'tc_percentage' => 'nullable|numeric|min:0|max:100',
            'total_deduction' => 'nullable|numeric|min:0',
            'net_received_amount' => 'nullable|numeric|min:0',
            'payment_ref_number' => 'nullable|string|max:255|required_if:payment_status,Received',
            'payment_date' => 'nullable|date|required_if:payment_status,Received',
            'payment_remarks' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.material_id' => 'nullable|exists:material_lists,id',
            'details.*.work_id' => 'nullable|exists:works,id',
            'details.*.quantity' => 'required|numeric|min:0',
            'details.*.unit' => 'required|string|max:50',
            'details.*.rate' => 'required|numeric|min:0',
            'details.*.amount' => 'nullable|numeric|min:0',
            'details.*.gst_percentage' => 'nullable|numeric|in:0,5,18',
            'details.*.sub_total' => 'nullable|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'details.*.material_id.required_without' => 'Either Material or Work must be selected.',
            'details.*.work_id.required_without' => 'Either Material or Work must be selected.',
        ];
    }
}
