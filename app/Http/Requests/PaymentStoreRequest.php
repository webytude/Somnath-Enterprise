<?php

namespace App\Http\Requests;

use App\Models\WorkOrder;
use Closure;
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
            'amount_payable' => [
                'required',
                'numeric',
                'min:0',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->input('payment_type') !== 'vendor') {
                        return;
                    }
                    $woId = $this->input('work_order_id');
                    if (! $woId) {
                        return;
                    }
                    $wo = WorkOrder::query()->find($woId);
                    if (! $wo) {
                        return;
                    }
                    $exclude = $this->route('payment');
                    $excludeId = $exclude ? (int) $exclude->getKey() : null;
                    $max = $wo->vendorRemainingPayableExcludingPayment($excludeId);
                    if ((float) $value > $max + 0.009) {
                        $fail('Amount cannot exceed work order balance (₹'.number_format($max, 2).').');
                    }
                },
            ],
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
            $rules['material_inward_ids'] = 'nullable|array';
            $rules['material_inward_ids.*'] = 'integer|exists:material_inwards,id';
            $rules['reason_bill_no'] = 'nullable|string|max:255';
            $rules['bill_payable'] = 'nullable|numeric|min:0';
        }

        // Vendor payment validation
        if ($paymentType === 'vendor') {
            $rules['vendor_id'] = 'required|exists:contractors,id';
            $rules['work_order_id'] = [
                'required',
                'exists:work_orders,id',
                function (string $attribute, mixed $value, Closure $fail) {
                    $wo = WorkOrder::query()->find($value);
                    $vendorId = $this->input('vendor_id');
                    if (! $wo || (int) $wo->contractor_id !== (int) $vendorId) {
                        $fail('The work order does not belong to the selected vendor.');
                    }
                },
            ];
            $rules['reason_bill_no'] = 'nullable|string|max:255';
            $rules['bill_payable'] = 'nullable|numeric|min:0';
        }

        return $rules;
    }
}
