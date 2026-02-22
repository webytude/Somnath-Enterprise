<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StageStoreRequest extends FormRequest
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
        $stageId = $this->route('stage');
        $stageId = is_object($stageId) ? $stageId->id : $stageId;
        
        return [
            'name' => 'required|string|max:255|unique:stages,name,' . $stageId,
            'percentage' => 'required|numeric|min:0|max:100',
        ];
    }
}
