<?php

namespace App\Http\Controllers\Api;

use App\Models\Pedhi;
use App\Http\Resources\PedhiResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web PedhiController.
 *
 * Follows the established API template:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web FormRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 */
class PedhiController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('pedhi');
    }

    public function index(Request $request): JsonResponse
    {
        $pedhi = Pedhi::latest()->get();

        return $this->ok(PedhiResource::collection($pedhi));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:pedhi,name',
        ]);
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        $pedhi = Pedhi::create($data);

        return $this->ok(new PedhiResource($pedhi), 'Pedhi created.', 201);
    }

    public function show(Pedhi $pedhi): JsonResponse
    {
        return $this->ok(new PedhiResource($pedhi));
    }

    public function update(Request $request, Pedhi $pedhi): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:pedhi,name,' . $pedhi->id,
        ]);
        $data['updated_by'] = Auth::id();

        $pedhi->update($data);

        return $this->ok(new PedhiResource($pedhi), 'Pedhi updated.');
    }

    public function destroy(Pedhi $pedhi): JsonResponse
    {
        $pedhi->delete();

        return $this->ok(null, 'Pedhi deleted.');
    }
}
