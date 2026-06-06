<?php

namespace App\Http\Controllers\Api;

use App\Models\MaterialList;
use App\Http\Resources\MaterialListResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web MaterialListController.
 *
 * Follows the established API template:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors MaterialListStoreRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 */
class MaterialListController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('material-lists');
    }

    public function index(Request $request): JsonResponse
    {
        $query = MaterialList::with('materialCategory')->latest();

        if ($request->filled('category_id')) {
            $query->where('material_category_id', $request->category_id);
        }

        $materialLists = $query->get();

        return $this->ok(MaterialListResource::collection($materialLists));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'material_category_id' => 'required|exists:material_categories,id',
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:50',
            'remark' => 'nullable|string',
        ]);
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        $materialList = MaterialList::create($data);

        return $this->ok(new MaterialListResource($materialList), 'Material List created.', 201);
    }

    public function show(MaterialList $materialList): JsonResponse
    {
        $materialList->load('materialCategory');

        return $this->ok(new MaterialListResource($materialList));
    }

    public function update(Request $request, MaterialList $materialList): JsonResponse
    {
        $data = $request->validate([
            'material_category_id' => 'required|exists:material_categories,id',
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:50',
            'remark' => 'nullable|string',
        ]);
        $data['updated_by'] = Auth::id();

        $materialList->update($data);

        return $this->ok(new MaterialListResource($materialList), 'Material List updated.');
    }

    public function destroy(MaterialList $materialList): JsonResponse
    {
        $materialList->delete();

        return $this->ok(null, 'Material List deleted.');
    }
}
