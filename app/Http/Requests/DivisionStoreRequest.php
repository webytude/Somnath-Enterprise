<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DivisionStoreRequest extends FormRequest
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
        $divisionId = $this->route('division');
        $divisionId = is_object($divisionId) ? $divisionId->id : $divisionId;
        
        return [
            'name' => 'required|string|max:255|unique:divisions,name,' . $divisionId,
            'department_id' => 'required|exists:departments,id',
            'subdepartment_id' => 'required|exists:subdepartments,id',
            'head_of_division_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'head_mobile_number' => 'nullable|string|max:20',
            'contact_number' => 'nullable|string|max:20',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_mobile_number' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
        ];
    }
}
