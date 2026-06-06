<?php

namespace App\Http\Controllers\Api;

use App\Models\ScrapMaterial;
use App\Http\Resources\ScrapMaterialResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web ScrapMaterialController.
 *
 * Follows the established API TEMPLATE:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web FormRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 */
class ScrapMaterialController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('scrap-materials');
    }

    public function index(Request $request): JsonResponse
    {
        $scrapMaterials = ScrapMaterial::latest()->get();

        return $this->ok(ScrapMaterialResource::collection($scrapMaterials));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'date'  => 'required|date',
        ]);
        $data['created_by'] = Auth::id();

        $scrapMaterial = ScrapMaterial::create($data);

        return $this->ok(new ScrapMaterialResource($scrapMaterial), 'Scrap material created.', 201);
    }

    public function show(ScrapMaterial $scrapMaterial): JsonResponse
    {
        return $this->ok(new ScrapMaterialResource($scrapMaterial));
    }

    public function update(Request $request, ScrapMaterial $scrapMaterial): JsonResponse
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'date'  => 'required|date',
        ]);
        $data['updated_by'] = Auth::id();

        $scrapMaterial->update($data);

        return $this->ok(new ScrapMaterialResource($scrapMaterial), 'Scrap material updated.');
    }

    public function destroy(ScrapMaterial $scrapMaterial): JsonResponse
    {
        $scrapMaterial->delete();

        return $this->ok(null, 'Scrap material deleted.');
    }
}
