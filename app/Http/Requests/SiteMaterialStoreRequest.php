<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteMaterialStoreRequest extends FormRequest
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
            'party_id' => 'required|exists:parties,id',
            'gst' => 'nullable|string|max:50',
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_inward' => 'nullable|boolean',
            'remark' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.material_name' => 'required|string|max:255',
            'details.*.unit' => 'required|string|max:50',
            'details.*.rate' => 'required|numeric|min:0',
            'details.*.quantity' => 'required|numeric|min:0',
            'details.*.gst' => 'nullable|string|max:50',
        ];
    }
}
