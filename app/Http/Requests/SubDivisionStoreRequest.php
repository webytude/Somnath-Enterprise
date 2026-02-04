<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubDivisionStoreRequest extends FormRequest
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
        $subDivisionId = $this->route('sub-division');
        $subDivisionId = is_object($subDivisionId) ? $subDivisionId->id : $subDivisionId;
        
        return [
            'name' => 'required|string|max:255|unique:sub_divisions,name,' . $subDivisionId,
            'division_id' => 'required|exists:divisions,id',
            'head_of_sub_division' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'name_of_sub_div_head' => 'nullable|string|max:255',
            'head_mobile_number' => 'nullable|string|max:20',
            'sub_div_contact_person_name' => 'nullable|string|max:255',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_mobile_number' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
        ];
    }
}
