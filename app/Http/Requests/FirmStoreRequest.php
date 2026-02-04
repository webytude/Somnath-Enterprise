<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FirmStoreRequest extends FormRequest
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
        $firmId = $this->route('firm');
        $firmId = is_object($firmId) ? $firmId->id : $firmId;
        
        return [
            'name' => 'required|string|max:255|unique:firms,name,' . $firmId,
            'address' => 'nullable|string',
            'pancard' => 'nullable|string|max:20',
            'gst' => 'nullable|string|max:20',
            'pf_code' => 'nullable|string|max:50',
            'mobile_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
            'head_name' => 'nullable|string|max:255',
            'head_mobile_number' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
        ];
    }
}
