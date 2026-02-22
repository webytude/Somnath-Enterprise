<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentStoreRequest extends FormRequest
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
        $paymentType = $this->input('payment_type');
        
        $rules = [
            'payment_type' => 'required|in:staff,party,vendor',
            'payment_date' => 'required|date',
            'amount_payable' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'ref_number' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'tds_percentage' => 'nullable|numeric|min:0|max:100',
            'total_deduction' => 'nullable|numeric|min:0',
        ];

        // Staff payment validation
        if ($paymentType === 'staff') {
            $rules['staff_id'] = 'required|exists:staff,id';
            $rules['salary_payable'] = 'nullable|numeric|min:0';
            $rules['expense_payable'] = 'nullable|numeric|min:0';
            $rules['total_payable'] = 'nullable|numeric|min:0';
            $rules['reason_of_payment'] = 'nullable|string|max:255';
        }

        // Party payment validation
        if ($paymentType === 'party') {
            $rules['party_id'] = 'required|exists:parties,id';
            $rules['reason_bill_no'] = 'nullable|string|max:255';
            $rules['bill_payable'] = 'nullable|numeric|min:0';
        }

        // Vendor payment validation
        if ($paymentType === 'vendor') {
            $rules['vendor_id'] = 'required|exists:contractors,id';
            $rules['reason_bill_no'] = 'nullable|string|max:255';
            $rules['bill_payable'] = 'nullable|numeric|min:0';
        }

        return $rules;
    }
}
