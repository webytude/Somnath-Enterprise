<?php

namespace App\Http\Controllers\Api;

use App\Models\MaterialCategory;
use App\Http\Resources\MaterialCategoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web MaterialCategoryController.
 *
 * Follows the established API TEMPLATE:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web FormRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 */
class MaterialCategoryController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('material-categories');
    }

    public function index(Request $request): JsonResponse
    {
        $materialCategories = MaterialCategory::latest()->get();

        return $this->ok(MaterialCategoryResource::collection($materialCategories));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:material_categories,name',
        ]);
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        $materialCategory = MaterialCategory::create($data);

        return $this->ok(new MaterialCategoryResource($materialCategory), 'Material Category created.', 201);
    }

    public function show(MaterialCategory $materialCategory): JsonResponse
    {
        return $this->ok(new MaterialCategoryResource($materialCategory));
    }

    public function update(Request $request, MaterialCategory $materialCategory): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:material_categories,name,' . $materialCategory->id,
        ]);
        $data['updated_by'] = Auth::id();

        $materialCategory->update($data);

        return $this->ok(new MaterialCategoryResource($materialCategory), 'Material Category updated.');
    }

    public function destroy(MaterialCategory $materialCategory): JsonResponse
    {
        $materialCategory->delete();

        return $this->ok(null, 'Material Category deleted.');
    }
}
