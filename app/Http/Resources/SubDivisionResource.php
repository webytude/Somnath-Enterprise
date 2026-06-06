<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubDivisionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                           => $this->id,
            'name'                         => $this->name,
            'division_id'                  => $this->division_id,
            'head_of_sub_division'         => $this->head_of_sub_division,
            'address'                      => $this->address,
            'name_of_sub_div_head'         => $this->name_of_sub_div_head,
            'head_mobile_number'           => $this->head_mobile_number,
            'sub_div_contact_person_name'  => $this->sub_div_contact_person_name,
            'contact_person_name'          => $this->contact_person_name,
            'contact_person_mobile_number' => $this->contact_person_mobile_number,
            'remark'                       => $this->remark,
            'created_by'                   => $this->created_by,
            'updated_by'                   => $this->updated_by,
            'created_at'                   => $this->created_at,
            'updated_at'                   => $this->updated_at,
            // Eager-loaded only on the list/show that asks for it.
            'division' => $this->whenLoaded('division', fn () => [
                'id'   => $this->division->id,
                'name' => $this->division->name,
            ]),
        ];
    }
}
