<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StageResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'percentage'  => $this->percentage,
            'location_id' => $this->location_id,
            'work_id'     => $this->work_id,
            'created_by'  => $this->created_by,
            'updated_by'  => $this->updated_by,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            // Eager-loaded only on the list/show that asks for it.
            'location' => $this->whenLoaded('location', fn () => [
                'id'   => $this->location->id,
                'name' => $this->location->name,
            ]),
            'work' => $this->whenLoaded('work', fn () => [
                'id'           => $this->work->id,
                'name_of_work' => $this->work->name_of_work,
            ]),
        ];
    }
}
