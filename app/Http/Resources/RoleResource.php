<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            // Present only when withCount('permissions') was used (index).
            'permissions_count' => $this->whenCounted('permissions'),
            // Eager-loaded only on the list/show that asks for it.
            'permissions' => $this->whenLoaded('permissions', fn () =>
                $this->permissions->map(fn ($p) => [
                    'id'   => $p->id,
                    'name' => $p->name,
                ])
            ),
        ];
    }
}
