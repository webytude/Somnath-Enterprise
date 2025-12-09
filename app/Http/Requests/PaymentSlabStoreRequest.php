<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentSlabStoreRequest extends FormRequest
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
        $paymentSlab = $this->route('payment_slab') ?? $this->route('payment-slab');
        $paymentSlabId = $paymentSlab ? $paymentSlab->id : null;
        
        return [
            'name' => 'required|string|max:255|unique:payment_slabs,name,' . $paymentSlabId,
        ];
    }
}
