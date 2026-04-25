<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

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
        return [
            'location_id' => 'required|exists:locations,id',
            'work_id' => 'required|exists:works,id',
            'stages' => 'required|array|min:1',
            'stages.*.name' => 'required|string|max:255',
            'stages.*.percentage' => 'required|numeric|min:0|max:100',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $stages = $this->input('stages', []);
            $total = collect($stages)->sum(function ($row) {
                return is_array($row) ? (float) ($row['percentage'] ?? 0) : 0;
            });

            if ($total > 100) {
                $validator->errors()->add('stages', 'Total site percentage cannot be greater than 100.');
            }
        });
    }
}
