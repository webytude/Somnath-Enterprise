<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillInwardResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'firm_id'            => $this->firm_id,
            'party_id'           => $this->party_id,
            'party_gst'          => $this->party_gst,
            'party_pan'          => $this->party_pan,
            'bill_number'        => $this->bill_number,
            'bill_date'          => $this->bill_date,
            'bill_attachment'    => $this->bill_attachment,
            'add_bhadu_labour'   => $this->add_bhadu_labour,
            'total_bill_amount'  => $this->total_bill_amount,
            'remarks'            => $this->remarks,
            'payment_status'     => $this->payment_status,
            'payment_ref_number' => $this->payment_ref_number,
            'payment_date'       => $this->payment_date,
            'payment_remarks'    => $this->payment_remarks,
            'created_by'         => $this->created_by,
            'updated_by'         => $this->updated_by,
            'created_at'         => $this->created_at,
            'updated_at'         => $this->updated_at,
            // Eager-loaded relationships only.
            'firm' => $this->whenLoaded('firm', fn () => [
                'id'   => $this->firm->id,
                'name' => $this->firm->name,
            ]),
            'party' => $this->whenLoaded('party', fn () => [
                'id'   => $this->party->id,
                'name' => $this->party->name,
            ]),
            'details' => $this->whenLoaded('details', fn () =>
                $this->details->map(fn ($d) => [
                    'id'             => $d->id,
                    'bill_inward_id' => $d->bill_inward_id,
                    'material_id'    => $d->material_id,
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
