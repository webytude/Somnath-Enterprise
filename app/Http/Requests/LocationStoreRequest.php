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

    protected function prepareForValidation(): void
    {
        foreach (['subdepartment_id', 'department_id', 'division_id'] as $key) {
            if ($this->has($key) && $this->input($key) === '') {
                $this->merge([$key => null]);
            }
        }
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
        
        $isStore = $this->routeIs('locations.store');

        return [
            'firm_id' => 'required|exists:firms,id',
            'department_id' => $isStore ? 'required|exists:departments,id' : 'nullable|exists:departments,id',
            'subdepartment_id' => $isStore ? 'required|exists:subdepartments,id' : 'nullable|exists:subdepartments,id',
            'division_id' => $isStore ? 'required|exists:divisions,id' : 'nullable|exists:divisions,id',
            'sub_division_id' => 'nullable|exists:sub_divisions,id',
            'name' => 'required|string|max:255',
            'remark' => 'nullable|string',
        ];
    }
}
