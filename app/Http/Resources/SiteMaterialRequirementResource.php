<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteMaterialRequirementResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'location_id' => $this->location_id,
            'work_id'     => $this->work_id,
            'created_by'  => $this->created_by,
            'updated_by'  => $this->updated_by,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            // Eager-loaded relationships.
            'location' => $this->whenLoaded('location', fn () => [
                'id'   => $this->location->id,
                'name' => $this->location->name,
            ]),
            'details' => $this->whenLoaded('details', fn () =>
                $this->details->map(fn ($d) => [
                    'id'               => $d->id,
                    'material_id'      => $d->material_id,
                    'unit'             => $d->unit,
                    'quantity'         => $d->quantity,
                    'date'             => $d->date,
                    'time_within_days' => $d->time_within_days,
                    'remark'           => $d->remark,
                    'material'         => $d->relationLoaded('material') && $d->material ? [
                        'id'   => $d->material->id,
                        'name' => $d->material->name,
                    ] : null,
                ])
            ),
        ];
    }
}
