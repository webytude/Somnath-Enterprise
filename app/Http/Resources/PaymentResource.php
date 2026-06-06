<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'payment_type'      => $this->payment_type,
            'staff_id'          => $this->staff_id,
            'party_id'          => $this->party_id,
            'vendor_id'         => $this->vendor_id,
            'work_order_id'     => $this->work_order_id,
            'salary_payable'    => $this->salary_payable,
            'expense_payable'   => $this->expense_payable,
            'total_payable'     => $this->total_payable,
            'reason_of_payment' => $this->reason_of_payment,
            'reason_bill_no'    => $this->reason_bill_no,
            'bill_payable'      => $this->bill_payable,
            'amount_payable'    => $this->amount_payable,
            'tds_percentage'    => $this->tds_percentage,
            'total_deduction'   => $this->total_deduction,
            'paid_amount'       => $this->paid_amount,
            'ref_number'        => $this->ref_number,
            'payment_date'      => $this->payment_date,
            'remarks'           => $this->remarks,
            'created_by'        => $this->created_by,
            'updated_by'        => $this->updated_by,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,

            // Eager-loaded relationships (only when loaded).
            'staff' => $this->whenLoaded('staff'),
            'party' => $this->whenLoaded('party'),
            'vendor' => $this->whenLoaded('vendor'),
            'work_order' => $this->whenLoaded('workOrder'),
            'creator' => $this->whenLoaded('creator'),
            'updater' => $this->whenLoaded('updater'),
        ];
    }
}
