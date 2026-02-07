<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkStoreRequest extends FormRequest
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
            'firm_id' => 'required|exists:firms,id',
            'department_id' => 'required|exists:departments,id',
            'subdepartment_id' => 'required|exists:subdepartments,id',
            'division_id' => 'required|exists:divisions,id',
            'sub_division_id' => 'nullable|exists:sub_divisions,id',
            'location_id' => 'required|exists:locations,id',
            'name_of_work' => 'required|string|max:255',
            'description_of_work' => 'nullable|string',
            'tender_id' => 'nullable|string|max:255',
            'estimate_cost' => 'nullable|numeric|min:0',
            'equal_above_below_on_estimate' => 'nullable|in:0,+,-',
            'final_amt_of_work' => 'nullable|numeric|min:0',
            'add_18_percent_gst' => 'nullable|numeric|min:0',
            'our_final_work_amt' => 'nullable|numeric|min:0',
            'time_limit_years_months' => 'nullable|string|max:50',
            'work_order_no' => 'nullable|string|max:255',
            'wo_date' => 'nullable|date',
            'end_date_of_work' => 'nullable|date',
            'work_start_date' => 'nullable|date',
            'if_extend_date' => 'nullable|boolean',
            'extended_date' => 'nullable|date',
        ];
    }
}
