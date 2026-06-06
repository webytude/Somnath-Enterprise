<?php

namespace App\Http\Controllers\Api;

use App\Models\ScrapList;
use App\Http\Resources\ScrapListResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web ScrapListController.
 *
 * Follows the established API template:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web ScrapListStoreRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 */
class ScrapListController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('scrap-lists');
    }

    public function index(Request $request): JsonResponse
    {
        $scrapLists = ScrapList::with('material')->latest()->get();

        return $this->ok(ScrapListResource::collection($scrapLists));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'feriya' => 'nullable|string|max:255',
            'date' => 'required|date',
            'unit' => 'nullable|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'where_place' => 'nullable|string|max:255',
            'labour_of_scrape' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
            'material_id' => 'nullable|exists:scrap_materials,id',
        ]);
        $data['created_by'] = Auth::id();

        $scrapList = ScrapList::create($data);

        return $this->ok(new ScrapListResource($scrapList), 'Scrap list created.', 201);
    }

    public function show(ScrapList $scrapList): JsonResponse
    {
        $scrapList->load('material');

        return $this->ok(new ScrapListResource($scrapList));
    }

    public function update(Request $request, ScrapList $scrapList): JsonResponse
    {
        $data = $request->validate([
            'feriya' => 'nullable|string|max:255',
            'date' => 'required|date',
            'unit' => 'nullable|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'where_place' => 'nullable|string|max:255',
            'labour_of_scrape' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
            'material_id' => 'nullable|exists:scrap_materials,id',
        ]);
        $data['updated_by'] = Auth::id();

        $scrapList->update($data);

        return $this->ok(new ScrapListResource($scrapList), 'Scrap list updated.');
    }

    public function destroy(ScrapList $scrapList): JsonResponse
    {
        $scrapList->delete();

        return $this->ok(null, 'Scrap list deleted.');
    }
}
