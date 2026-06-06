<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteProgressResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'location_id'      => $this->location_id,
            'work_id'          => $this->work_id,
            'work_name'        => $this->work_name,
            'work_site'        => $this->work_site,
            'work_stage'       => $this->work_stage,
            'stage_id'         => $this->stage_id,
            'stage_percentage' => $this->stage_percentage,
            'remark'           => $this->remark,
            'photo_url'        => $this->photo_url,
            'date'             => $this->date,
            'created_by'       => $this->created_by,
            'updated_by'       => $this->updated_by,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
            // Eager-loaded only on the list/show that asks for it.
            'location' => $this->whenLoaded('location', fn () => [
                'id'   => $this->location->id,
                'name' => $this->location->name,
            ]),
        ];
    }
}
