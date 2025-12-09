<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScrapListStoreRequest extends FormRequest
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
            'feriya' => 'nullable|string|max:255',
            'date' => 'required|date',
            'unit' => 'nullable|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'where_place' => 'nullable|string|max:255',
            'labour_of_scrape' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
            'material_id' => 'nullable|exists:scrap_materials,id',
        ];
    }
}
