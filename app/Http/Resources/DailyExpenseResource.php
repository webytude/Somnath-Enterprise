<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyExpenseResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'staff_id'    => $this->staff_id,
            'location_id' => $this->location_id,
            'date'        => $this->date,
            'amount'      => $this->amount,
            'description' => $this->description,
            'remark'      => $this->remark,
            'created_by'  => $this->created_by,
            'updated_by'  => $this->updated_by,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            // Eager-loaded only on the list/show that asks for them.
            'staff' => $this->whenLoaded('staff', fn () => [
                'id'         => $this->staff->id,
                'first_name' => $this->staff->first_name,
            ]),
            'location' => $this->whenLoaded('location', fn () => [
                'id'   => $this->location->id,
                'name' => $this->location->name,
            ]),
        ];
    }
}
