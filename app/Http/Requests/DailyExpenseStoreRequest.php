<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailyExpenseStoreRequest extends FormRequest
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
        // If logged in as staff, staff_id is not required (will be set automatically)
        $staffIdRule = 'required|exists:staff,id';
        if (auth()->check() && auth()->user()->isStaff() && auth()->user()->staff) {
            $staffIdRule = 'nullable|exists:staff,id';
        }
        
        return [
            'staff_id' => $staffIdRule,
            'location_id' => 'nullable|exists:locations,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'remark' => 'nullable|string',
        ];
    }
}
