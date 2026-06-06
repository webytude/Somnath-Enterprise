<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillOutwardResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                       => $this->id,
            'firm_id'                  => $this->firm_id,
            'firm_gst'                 => $this->firm_gst,
            'bill_number'              => $this->bill_number,
            'bill_date'                => $this->bill_date,
            'bill_attachment'          => $this->bill_attachment,
            'party_id'                 => $this->party_id,
            'party_gst'                => $this->party_gst,
            'party_address'            => $this->party_address,
            'add_bhadu_labour'         => $this->add_bhadu_labour,
            'total_bill_amount'        => $this->total_bill_amount,
            'remarks'                  => $this->remarks,
            'payment_status'           => $this->payment_status,
            'sd_percentage'            => $this->sd_percentage,
            'tds_percentage'           => $this->tds_percentage,
            'gst_deduction_percentage' => $this->gst_deduction_percentage,
            'lc_percentage'            => $this->lc_percentage,
            'tc_percentage'            => $this->tc_percentage,
            'total_deduction'          => $this->total_deduction,
            'net_received_amount'      => $this->net_received_amount,
            'payment_ref_number'       => $this->payment_ref_number,
            'payment_date'             => $this->payment_date,
            'payment_remarks'          => $this->payment_remarks,
            'created_by'               => $this->created_by,
            'updated_by'               => $this->updated_by,
            'created_at'               => $this->created_at,
            'updated_at'               => $this->updated_at,

            'firm' => $this->whenLoaded('firm', fn () => [
                'id'   => $this->firm->id,
                'name' => $this->firm->name,
                'gst'  => $this->firm->gst,
            ]),
            'party' => $this->whenLoaded('party', fn () => [
                'id'      => $this->party->id,
                'name'    => $this->party->name,
                'gst'     => $this->party->gst,
                'address' => $this->party->address,
            ]),
            'details' => $this->whenLoaded('details', fn () =>
                $this->details->map(fn ($d) => [
                    'id'              => $d->id,
                    'bill_outward_id' => $d->bill_outward_id,
                    'material_id'     => $d->material_id,
                    'work_id'         => $d->work_id,
                    'quantity'        => $d->quantity,
                    'unit'            => $d->unit,
                    'rate'            => $d->rate,
                    'amount'          => $d->amount,
                    'gst_percentage'  => $d->gst_percentage,
                    'sub_total'       => $d->sub_total,
                    'material'        => $d->relationLoaded('material') && $d->material ? [
                        'id'   => $d->material->id,
                        'name' => $d->material->name,
                    ] : null,
                    'work'            => $d->relationLoaded('work') && $d->work ? [
                        'id'           => $d->work->id,
                        'name_of_work' => $d->work->name_of_work,
                    ] : null,
                ])
            ),
        ];
    }
}
