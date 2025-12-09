<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GstBillListStoreRequest extends FormRequest
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
            'party_name' => 'required|string|max:255',
            'gst' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:20',
            'is_inward_outward' => 'required|in:Inward,Outward',
            'invoice_number' => 'nullable|string|max:255',
            'invoice_date' => 'nullable|date',
            'basic_amount' => 'required|numeric|min:0',
            'gst_amount' => 'nullable|numeric|min:0',
            'total_bill_amount' => 'required|numeric|min:0',
            'status' => 'required|in:Pending,Paid',
            'ref_number' => 'nullable|string|max:255',
            'payment_date' => 'nullable|date',
            'debit_from' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
            'gst_slab' => 'required|in:5,18',
        ];
    }
}
