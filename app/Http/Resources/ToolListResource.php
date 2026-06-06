<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ToolListResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'location_id'    => $this->location_id,
            'shelf_location' => $this->shelf_location,
            'name'           => $this->name,
            'quantity'       => $this->quantity,
            'person_name'    => $this->person_name,
            'date'           => $this->date,
            'price'          => $this->price,
            'remark'         => $this->remark,
            'created_by'     => $this->created_by,
            'updated_by'     => $this->updated_by,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
            // Eager-loaded only on the list/show that asks for it.
            'location'       => $this->whenLoaded('location', fn () => [
                'id'   => $this->location->id,
                'name' => $this->location->name,
            ]),
        ];
    }
}
