<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialInwardResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                           => $this->id,
            'location_id'                  => $this->location_id,
            'work_id'                      => $this->work_id,
            'party_id'                     => $this->party_id,
            'party_gst'                    => $this->party_gst,
            'party_pan'                    => $this->party_pan,
            'bill_voucher_type'            => $this->bill_voucher_type,
            'bill_voucher_number'          => $this->bill_voucher_number,
            'bill_voucher_date'            => $this->bill_voucher_date,
            'material_inward_at_site_date' => $this->material_inward_at_site_date,
            'bill_voucher_attachment'      => $this->bill_voucher_attachment,
            'add_bhadu'                    => $this->add_bhadu,
            'total_bill_voucher_amount'    => $this->total_bill_voucher_amount,
            'payment_status'               => $this->payment_status,
            'payment_ref_number'           => $this->payment_ref_number,
            'payment_date'                 => $this->payment_date,
            'payment_remarks'              => $this->payment_remarks,
            'remarks'                      => $this->remarks,
            'created_by'                   => $this->created_by,
            'updated_by'                   => $this->updated_by,
            'created_at'                   => $this->created_at,
            'updated_at'                   => $this->updated_at,

            // Eager-loaded relationships only when present.
            'location' => $this->whenLoaded('location', fn () => [
                'id'   => $this->location->id,
                'name' => $this->location->name,
            ]),
            'work' => $this->whenLoaded('work', fn () => $this->work ? [
                'id'           => $this->work->id,
                'name_of_work' => $this->work->name_of_work,
            ] : null),
            'party' => $this->whenLoaded('party', fn () => [
                'id'   => $this->party->id,
                'name' => $this->party->name,
            ]),
            'details' => $this->whenLoaded('details', fn () =>
                $this->details->map(fn ($d) => [
                    'id'             => $d->id,
                    'material_id'    => $d->material_id,
                    'make'           => $d->make,
                    'quantity'       => $d->quantity,
                    'unit'           => $d->unit,
                    'rate'           => $d->rate,
                    'amount'         => $d->amount,
                    'gst_percentage' => $d->gst_percentage,
                    'sub_total'      => $d->sub_total,
                    'material'       => $d->relationLoaded('material') && $d->material ? [
                        'id'   => $d->material->id,
                        'name' => $d->material->name,
                    ] : null,
                ])
            ),
        ];
    }
}
