<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteProgressStoreRequest extends FormRequest
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
            'work_id' => 'nullable|exists:works,id',
            'work_name' => 'nullable|string|max:255',
            'work_site' => 'required|string|max:255',
            'work_stage' => 'nullable|string',
            'stage_id' => 'nullable|exists:stages,id',
            'stage_percentage' => 'nullable|numeric|min:0|max:100',
            'remark' => 'nullable|string',
            'photo_url' => 'nullable|url|max:500',
            'date' => 'required|date',
        ];
    }
}
