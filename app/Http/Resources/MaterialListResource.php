<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialListResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'material_category_id' => $this->material_category_id,
            'name'                 => $this->name,
            'unit'                 => $this->unit,
            'remark'               => $this->remark,
            'created_by'           => $this->created_by,
            'updated_by'           => $this->updated_by,
            'created_at'           => $this->created_at,
            'updated_at'           => $this->updated_at,
            // Eager-loaded only on the list/show that asks for it.
            'material_category'    => $this->whenLoaded('materialCategory', fn () => [
                'id'   => $this->materialCategory->id,
                'name' => $this->materialCategory->name,
            ]),
        ];
    }
}
