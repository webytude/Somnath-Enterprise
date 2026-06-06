<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                            => $this->id,
            'firm_id'                       => $this->firm_id,
            'department_id'                 => $this->department_id,
            'subdepartment_id'              => $this->subdepartment_id,
            'division_id'                   => $this->division_id,
            'sub_division_id'               => $this->sub_division_id,
            'location_id'                   => $this->location_id,
            'name_of_work'                  => $this->name_of_work,
            'description_of_work'           => $this->description_of_work,
            'tender_id'                     => $this->tender_id,
            'estimate_cost'                 => $this->estimate_cost,
            'equal_above_below_on_estimate' => $this->equal_above_below_on_estimate,
            'final_amt_of_work'             => $this->final_amt_of_work,
            'add_18_percent_gst'            => $this->add_18_percent_gst,
            'gst_amount'                    => $this->gst_amount,
            'our_final_work_amt'            => $this->our_final_work_amt,
            'time_limit_years_months'       => $this->time_limit_years_months,
            'work_order_no'                 => $this->work_order_no,
            'wo_date'                       => $this->wo_date,
            'end_date_of_work'              => $this->end_date_of_work,
            'work_start_date'               => $this->work_start_date,
            'if_extend_date'                => $this->if_extend_date,
            'extended_date'                 => $this->extended_date,
            'created_by'                    => $this->created_by,
            'updated_by'                    => $this->updated_by,
            'created_at'                    => $this->created_at,
            'updated_at'                    => $this->updated_at,
            // Eager-loaded relationships (only when loaded).
            'firm' => $this->whenLoaded('firm', fn () => [
                'id'   => $this->firm->id,
                'name' => $this->firm->name,
            ]),
            'department' => $this->whenLoaded('department', fn () => [
                'id'   => $this->department->id,
                'name' => $this->department->name,
            ]),
            'subdepartment' => $this->whenLoaded('subdepartment', fn () => [
                'id'   => $this->subdepartment->id,
                'name' => $this->subdepartment->name,
            ]),
            'division' => $this->whenLoaded('division', fn () => [
                'id'   => $this->division->id,
                'name' => $this->division->name,
            ]),
            'subDivision' => $this->whenLoaded('subDivision', fn () => [
                'id'   => $this->subDivision->id,
                'name' => $this->subDivision->name,
            ]),
            'location' => $this->whenLoaded('location', fn () => [
                'id'   => $this->location->id,
                'name' => $this->location->name,
            ]),
        ];
    }
}
