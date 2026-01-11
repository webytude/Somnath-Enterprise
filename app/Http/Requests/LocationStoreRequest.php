<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationStoreRequest extends FormRequest
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
        $locationId = $this->route('location');
        $locationId = is_object($locationId) ? $locationId->id : $locationId;
        
        return [
            'pedhi_id' => 'required|exists:pedhi,id',
            'department_id' => 'required|exists:departments,id',
            'subdepartment_id' => 'required|exists:subdepartments,id',
            'division_id' => 'required|exists:divisions,id',
            'sub_division_id' => 'nullable|exists:sub_divisions,id',
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'remark' => 'nullable|string',
        ];
    }
}
