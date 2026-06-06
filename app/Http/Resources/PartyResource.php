<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartyResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                        => $this->id,
            'name'                      => $this->name,
            'firm_id'                   => $this->firm_id,
            'gst'                       => $this->gst,
            'pancard'                   => $this->pancard,
            'address'                   => $this->address,
            'mobile'                    => $this->mobile,
            'contact_person_name'       => $this->contact_person_name,
            'contact_person_mobile'     => $this->contact_person_mobile,
            'remark'                    => $this->remark,
            'list_of_material'          => $this->list_of_material,
            'bank_account_holder_name'  => $this->bank_account_holder_name,
            'bank_name_branch'          => $this->bank_name_branch,
            'bank_account_no'           => $this->bank_account_no,
            'ifsc_code'                 => $this->ifsc_code,
            'created_by'                => $this->created_by,
            'updated_by'                => $this->updated_by,
            'created_at'                => $this->created_at,
            'updated_at'                => $this->updated_at,
            // Eager-loaded only on the list/show that asks for it.
            'firm' => $this->whenLoaded('firm', fn () => [
                'id'   => $this->firm->id,
                'name' => $this->firm->name,
            ]),
            'materials' => $this->whenLoaded('materials', fn () =>
                $this->materials->map(fn ($m) => [
                    'id'   => $m->id,
                    'name' => $m->name,
                ])
            ),
            'locations' => $this->whenLoaded('locations', fn () =>
                $this->locations->map(fn ($l) => [
                    'id'   => $l->id,
                    'name' => $l->name,
                ])
            ),
        ];
    }
}
