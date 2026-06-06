<?php

namespace App\Http\Controllers\Api;

use App\Models\ToolList;
use App\Http\Resources\ToolListResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web ToolListController.
 *
 * Follows the established API template:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web FormRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 *
 * ToolList is location-scoped, so index() uses forCurrentUser().
 */
class ToolListController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('tool-lists');
    }

    public function index(Request $request): JsonResponse
    {
        $toolLists = ToolList::forCurrentUser()->with('location')->latest()->get();

        return $this->ok(ToolListResource::collection($toolLists));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'location_id'    => 'required|exists:locations,id',
            'shelf_location' => 'nullable|string|max:255',
            'name'           => 'required|string|max:255',
            'quantity'       => 'required|numeric|min:0',
            'person_name'    => 'required|string|max:255',
            'date'           => 'required|date',
            'price'          => 'nullable|numeric|min:0',
            'remark'         => 'nullable|string',
        ]);
        $data['created_by'] = Auth::id();

        $toolList = ToolList::create($data);

        return $this->ok(new ToolListResource($toolList), 'Tool created.', 201);
    }

    public function show(ToolList $toolList): JsonResponse
    {
        $toolList->load('location');

        return $this->ok(new ToolListResource($toolList));
    }

    public function update(Request $request, ToolList $toolList): JsonResponse
    {
        $data = $request->validate([
            'location_id'    => 'required|exists:locations,id',
            'shelf_location' => 'nullable|string|max:255',
            'name'           => 'required|string|max:255',
            'quantity'       => 'required|numeric|min:0',
            'person_name'    => 'required|string|max:255',
            'date'           => 'required|date',
            'price'          => 'nullable|numeric|min:0',
            'remark'         => 'nullable|string',
        ]);
        $data['updated_by'] = Auth::id();

        $toolList->update($data);

        return $this->ok(new ToolListResource($toolList), 'Tool updated.');
    }

    public function destroy(ToolList $toolList): JsonResponse
    {
        $toolList->delete();

        return $this->ok(null, 'Tool deleted.');
    }
}
