<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubdepartmentStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:departments,name',
            'department_id' => 'required|exists:departments,id',
        ];
    }

    public function messages()
    {
        return [
            'department_id.exists' => 'The selected department is invalid.',
        ];
    }
}
