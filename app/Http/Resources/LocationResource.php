<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'firm_id'          => $this->firm_id,
            'department_id'    => $this->department_id,
            'subdepartment_id' => $this->subdepartment_id,
            'division_id'      => $this->division_id,
            'sub_division_id'  => $this->sub_division_id,
            'name'             => $this->name,
            'remark'           => $this->remark,
            'created_by'       => $this->created_by,
            'updated_by'       => $this->updated_by,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
            // Eager-loaded only on the list/show that asks for it.
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
        ];
    }
}
