<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillInwardStoreRequest extends FormRequest
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
            'party_id' => 'required|exists:parties,id',
            'bill_number' => 'nullable|string|max:255',
            'bill_date' => 'nullable|date',
            'bill_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'add_bhadu_labour' => 'nullable|numeric|min:0',
            'total_bill_amount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'payment_status' => 'required|in:Pending,Paid',
            'payment_ref_number' => 'nullable|string|max:255|required_if:payment_status,Paid',
            'payment_date' => 'nullable|date|required_if:payment_status,Paid',
            'payment_remarks' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.material_id' => 'required|exists:material_lists,id',
            'details.*.quantity' => 'required|numeric|min:0',
            'details.*.unit' => 'required|string|max:50',
            'details.*.rate' => 'required|numeric|min:0',
            'details.*.amount' => 'nullable|numeric|min:0',
            'details.*.gst_percentage' => 'nullable|numeric|in:0,5,18',
            'details.*.sub_total' => 'nullable|numeric|min:0',
        ];
    }
}
