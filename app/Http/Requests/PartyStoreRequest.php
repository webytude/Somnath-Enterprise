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
            'gst' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'mobile' => 'nullable|string|max:20',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_mobile' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'date' => 'nullable|date',
        ];
    }
}
