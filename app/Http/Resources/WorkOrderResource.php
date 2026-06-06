<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkOrderResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'work_order_number'   => $this->work_order_number,
            'number_prefix'       => $this->number_prefix,
            'fiscal_year_label'   => $this->fiscal_year_label,
            'sequence_number'     => $this->sequence_number,
            'order_date'          => $this->order_date,
            'contractor_id'       => $this->contractor_id,
            'subject'             => $this->subject,
            'condition_text'      => $this->condition_text,
            'total_order_value'   => $this->total_order_value,
            'vendor_paid_total'   => $this->vendor_paid_total,
            'time_limit_for_work' => $this->time_limit_for_work,
            'payment_condition'   => $this->payment_condition,
            'location_id'         => $this->location_id,
            'work_id'             => $this->work_id,
            'created_by'          => $this->created_by,
            'updated_by'          => $this->updated_by,
            'created_at'          => $this->created_at,
            'updated_at'          => $this->updated_at,
            // Eager-loaded relationships only.
            'contractor' => $this->whenLoaded('contractor'),
            'location'   => $this->whenLoaded('location'),
            'work'       => $this->whenLoaded('work'),
            'details'    => $this->whenLoaded('details', fn () =>
                $this->details->map(fn ($d) => [
                    'id'           => $d->id,
                    'sort_order'   => $d->sort_order,
                    'work_details' => $d->work_details,
                    'quantity'     => $d->quantity,
                    'unit'         => $d->unit,
                    'rate'         => $d->rate,
                    'amount'       => $d->amount,
                ])
            ),
            'vendor_payments' => $this->whenLoaded('vendorPayments'),
        ];
    }
}
