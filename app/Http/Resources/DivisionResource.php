<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DivisionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                           => $this->id,
            'name'                         => $this->name,
            'department_id'                => $this->department_id,
            'subdepartment_id'             => $this->subdepartment_id,
            'head_of_division_name'        => $this->head_of_division_name,
            'address'                      => $this->address,
            'head_mobile_number'           => $this->head_mobile_number,
            'contact_number'               => $this->contact_number,
            'contact_person_name'          => $this->contact_person_name,
            'contact_person_mobile_number' => $this->contact_person_mobile_number,
            'bank_name'                    => $this->bank_name,
            'bank_account_no'              => $this->bank_account_no,
            'ifsc_code'                    => $this->ifsc_code,
            'created_by'                   => $this->created_by,
            'updated_by'                   => $this->updated_by,
            'created_at'                   => $this->created_at,
            'updated_at'                   => $this->updated_at,
            // Eager-loaded only on the list/show that asks for it.
            'department' => $this->whenLoaded('department', fn () => [
                'id'   => $this->department->id,
                'name' => $this->department->name,
            ]),
            'subdepartment' => $this->whenLoaded('subdepartment', fn () => [
                'id'   => $this->subdepartment->id,
                'name' => $this->subdepartment->name,
            ]),
        ];
    }
}
