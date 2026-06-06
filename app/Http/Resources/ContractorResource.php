<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractorResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'pedhi'                 => $this->pedhi,
            'gst'                   => $this->gst,
            'pan'                   => $this->pan,
            'bank_name'             => $this->bank_name,
            'ifsc'                  => $this->ifsc,
            'branch_name'           => $this->branch_name,
            'bank_account_no'       => $this->bank_account_no,
            'address'               => $this->address,
            'mobile'                => $this->mobile,
            'contact_person'        => $this->contact_person,
            'contact_person_mobile' => $this->contact_person_mobile,
            'ref_by'                => $this->ref_by,
            'ref_cont_no'           => $this->ref_cont_no,
            'payment_term'          => $this->payment_term,
            'amount'                => $this->amount,
            'remaining_amount'      => $this->remaining_amount,
            'payment_slab_id'       => $this->payment_slab_id,
            'created_by'            => $this->created_by,
            'updated_by'            => $this->updated_by,
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
            // Eager-loaded only on the list/show that asks for it.
            'payment_slab' => $this->whenLoaded('paymentSlab', fn () => $this->paymentSlab ? [
                'id'   => $this->paymentSlab->id,
                'name' => $this->paymentSlab->name,
            ] : null),
            'locations' => $this->whenLoaded('locations', fn () =>
                $this->locations->map(fn ($l) => [
                    'id'   => $l->id,
                    'name' => $l->name,
                ])
            ),
            'works' => $this->whenLoaded('works', fn () =>
                $this->works->map(fn ($w) => [
                    'id'           => $w->id,
                    'name_of_work' => $w->name_of_work,
                ])
            ),
        ];
    }
}
