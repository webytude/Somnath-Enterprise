<?php

namespace App\Http\Controllers\Api;

use App\Models\Stage;
use App\Http\Resources\StageResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * API counterpart of the web StageController.
 *
 * Follows the established API TEMPLATE:
 *   - JSON in / JSON out (no Blade views, no redirects)
 *   - per-action RBAC via permissionMiddleware() (HasMiddleware)
 *   - validation inline (mirrors the web StageStoreRequest rules)
 *   - stamps created_by / updated_by
 *   - wraps output in a JsonResource
 *
 * Stage is LocationScoped, so index() uses forCurrentUser().
 */
class StageController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('stages');
    }

    public function index(Request $request): JsonResponse
    {
        $stages = Stage::forCurrentUser()->with(['location', 'work'])->latest()->get();

        return $this->ok(StageResource::collection($stages));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'location_id' => 'required|exists:locations,id',
            'work_id' => 'required|exists:works,id',
            'stages' => 'required|array|min:1',
            'stages.*.name' => 'required|string|max:255',
            'stages.*.percentage' => 'required|numeric|min:0|max:100',
        ]);

        $total = collect($data['stages'])->sum(fn ($row) => (float) ($row['percentage'] ?? 0));
        if ($total > 100) {
            return $this->fail('Total site percentage cannot be greater than 100.', 422, [
                'stages' => ['Total site percentage cannot be greater than 100.'],
            ]);
        }

        $created = DB::transaction(function () use ($data) {
            $stages = [];
            foreach ($data['stages'] as $row) {
                $stages[] = Stage::create([
                    'name' => $row['name'],
                    'percentage' => $row['percentage'],
                    'location_id' => $data['location_id'],
                    'work_id' => $data['work_id'],
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);
            }
            return $stages;
        });

        $collection = collect($created)->each->load(['location', 'work']);

        return $this->ok(StageResource::collection($collection), 'Stage(s) created.', 201);
    }

    public function show(Stage $stage): JsonResponse
    {
        $stage->load(['location', 'work']);

        return $this->ok(new StageResource($stage));
    }

    public function update(Request $request, Stage $stage): JsonResponse
    {
        $data = $request->validate([
            'location_id' => 'required|exists:locations,id',
            'work_id' => 'required|exists:works,id',
            'stages' => 'required|array|min:1',
            'stages.*.name' => 'required|string|max:255',
            'stages.*.percentage' => 'required|numeric|min:0|max:100',
        ]);

        $total = collect($data['stages'])->sum(fn ($row) => (float) ($row['percentage'] ?? 0));
        if ($total > 100) {
            return $this->fail('Total site percentage cannot be greater than 100.', 422, [
                'stages' => ['Total site percentage cannot be greater than 100.'],
            ]);
        }

        DB::transaction(function () use ($data, $stage) {
            $rows = $data['stages'];

            // First row updates the current stage.
            $firstRow = $rows[0];
            $stage->update([
                'name' => $firstRow['name'],
                'percentage' => $firstRow['percentage'],
                'location_id' => $data['location_id'],
                'work_id' => $data['work_id'],
                'updated_by' => Auth::id(),
            ]);

            // Additional rows are created as new stages.
            $extraRows = array_slice($rows, 1);
            foreach ($extraRows as $row) {
                Stage::create([
                    'name' => $row['name'],
                    'percentage' => $row['percentage'],
                    'location_id' => $data['location_id'],
                    'work_id' => $data['work_id'],
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);
            }
        });

        $stage->load(['location', 'work']);

        return $this->ok(new StageResource($stage), 'Stage updated.');
    }

    public function destroy(Stage $stage): JsonResponse
    {
        $stage->delete();

        return $this->ok(null, 'Stage deleted.');
    }
}
