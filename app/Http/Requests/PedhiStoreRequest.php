<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedhiStoreRequest extends FormRequest
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
        $pedhiId = $this->route('pedhi');
        $pedhiId = is_object($pedhiId) ? $pedhiId->id : $pedhiId;
        
        return [
            'name' => 'required|string|max:255|unique:pedhi,name,' . $pedhiId,
        ];
    }
}
