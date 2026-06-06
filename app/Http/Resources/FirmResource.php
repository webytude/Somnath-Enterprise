<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FirmResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'address'            => $this->address,
            'pancard'            => $this->pancard,
            'gst'                => $this->gst,
            'pf_code'            => $this->pf_code,
            'mobile_number'      => $this->mobile_number,
            'email'              => $this->email,
            'bank_name'          => $this->bank_name,
            'bank_account_no'    => $this->bank_account_no,
            'ifsc_code'          => $this->ifsc_code,
            'head_name'          => $this->head_name,
            'head_mobile_number' => $this->head_mobile_number,
            'remark'             => $this->remark,
            'created_by'         => $this->created_by,
            'updated_by'         => $this->updated_by,
            'created_at'         => $this->created_at,
            'updated_at'         => $this->updated_at,
        ];
    }
}
