<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScrapListResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'feriya'           => $this->feriya,
            'date'             => $this->date,
            'unit'             => $this->unit,
            'quantity'         => $this->quantity,
            'where_place'      => $this->where_place,
            'labour_of_scrape' => $this->labour_of_scrape,
            'remark'           => $this->remark,
            'material_id'      => $this->material_id,
            'created_by'       => $this->created_by,
            'updated_by'       => $this->updated_by,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
            // Eager-loaded only on the list/show that asks for it.
            'material' => $this->whenLoaded('material', fn () => [
                'id'    => $this->material->id,
                'name'  => $this->material->name,
                'price' => $this->material->price,
                'date'  => $this->material->date,
            ]),
        ];
    }
}
