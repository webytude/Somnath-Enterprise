<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'user_id'               => $this->user_id,
            'code'                  => $this->code,
            'first_name'            => $this->first_name,
            'last_name'             => $this->last_name,
            'second_name'           => $this->second_name,
            'dob'                   => $this->dob,
            'doj'                   => $this->doj,
            'designation'           => $this->designation,
            'photo'                 => $this->photo,
            'permanent_address'     => $this->permanent_address,
            'present_address'       => $this->present_address,
            'mobile_number'         => $this->mobile_number,
            'other_contact_number'  => $this->other_contact_number,
            'relative_name'         => $this->relative_name,
            'relation'              => $this->relation,
            'relative_mobile_no'    => $this->relative_mobile_no,
            'gender'                => $this->gender,
            'marital_status'        => $this->marital_status,
            'blood_group'           => $this->blood_group,
            'aadhar_no'             => $this->aadhar_no,
            'pan_no'                => $this->pan_no,
            'uan_no'                => $this->uan_no,
            'esic_no'               => $this->esic_no,
            'bank_name'             => $this->bank_name,
            'bank_account_no'       => $this->bank_account_no,
            'ifsc_code'             => $this->ifsc_code,
            'date_of_leaving'       => $this->date_of_leaving,
            'no_of_years_service'   => $this->no_of_years_service,
            'remark'                => $this->remark,
            'rate_per_day'          => $this->rate_per_day,
            'rate_per_month'        => $this->rate_per_month,
            'salary_date'           => $this->salary_date,
            'created_by'            => $this->created_by,
            'updated_by'            => $this->updated_by,
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
            // Eager-loaded only on the list/show that asks for it.
            'user' => $this->whenLoaded('user', fn () => [
                'id'      => $this->user->id,
                'name'    => $this->user->name,
                'email'   => $this->user->email,
                'role_id' => $this->user->role_id,
            ]),
            'locations' => $this->whenLoaded('locations', fn () =>
                $this->locations->map(fn ($l) => [
                    'id'   => $l->id,
                    'name' => $l->name,
                ])
            ),
        ];
    }
}
