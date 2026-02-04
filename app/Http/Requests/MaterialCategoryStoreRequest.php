<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialCategoryStoreRequest extends FormRequest
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
        $materialCategoryId = $this->route('material-category');
        $materialCategoryId = is_object($materialCategoryId) ? $materialCategoryId->id : $materialCategoryId;
        
        return [
            'name' => 'required|string|max:255|unique:material_categories,name,' . $materialCategoryId,
        ];
    }
}
