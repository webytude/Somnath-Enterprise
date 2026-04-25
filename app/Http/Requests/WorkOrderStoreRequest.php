<?php

namespace App\Http\Requests;

use App\Models\Work;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class WorkOrderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'order_date' => 'required|date',
            'contractor_id' => 'required|exists:contractors,id',
            'subject' => 'nullable|string',
            'condition_text' => 'nullable|string',
            'time_limit_for_work' => 'nullable|string',
            'payment_condition' => 'nullable|string',
            'location_id' => [
                'required',
                'exists:locations,id',
                function (string $attribute, mixed $value, Closure $fail) {
                    $contractorId = $this->input('contractor_id');
                    if (! $contractorId) {
                        return;
                    }
                    $ok = DB::table('contractor_locations')
                        ->where('contractor_id', $contractorId)
                        ->where('location_id', $value)
                        ->exists();
                    if (! $ok) {
                        $fail('The selected location is not assigned to this vendor.');
                    }
                },
            ],
            'work_id' => [
                'nullable',
                'exists:works,id',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value === null || $value === '') {
                        return;
                    }
                    $contractorId = $this->input('contractor_id');
                    $locationId = $this->input('location_id');
                    if (! $contractorId) {
                        return;
                    }
                    $work = Work::query()->find($value);
                    if (! $work) {
                        $fail('Invalid work.');

                        return;
                    }
                    if ((string) $work->location_id !== (string) $locationId) {
                        $fail('The selected work does not belong to the selected location.');

                        return;
                    }
                    $ok = DB::table('contractor_works')
                        ->where('contractor_id', $contractorId)
                        ->where('work_id', $value)
                        ->exists();
                    if (! $ok) {
                        $fail('The selected work is not assigned to this vendor.');
                    }
                },
            ],
            'details' => 'required|array|min:1',
            'details.*.work_details' => 'required|string',
            'details.*.quantity' => 'required|numeric|min:0',
            'details.*.unit' => 'required|string|max:50',
            'details.*.rate' => 'required|numeric|min:0',
        ];

        if ($this->routeIs('work-orders.store')) {
            $rules['number_prefix'] = ['required', 'string', 'max:20'];
            $rules['fiscal_year_label'] = ['required', 'string', 'regex:/^\d{4}-\d{2}$/'];
        }

        return $rules;
    }
}
