<?php

namespace App\Http\Controllers\Api;

use App\Models\Firm;
use App\Http\Resources\FirmResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

/**
 * API counterpart of the web FirmController.
 * Follows the established API template: JSON in / JSON out, per-action RBAC,
 * inline validation mirroring the web FormRequest, created_by/updated_by stamps,
 * and JsonResource output.
 */
class FirmController extends ApiController implements HasMiddleware
{
    public static function middleware(): array
    {
        return self::permissionMiddleware('firms');
    }

    public function index(Request $request): JsonResponse
    {
        $firms = Firm::latest()->get();

        return $this->ok(FirmResource::collection($firms));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:firms,name',
            'address' => 'nullable|string',
            'pancard' => 'nullable|string|max:20',
            'gst' => 'nullable|string|max:20',
            'pf_code' => 'nullable|string|max:50',
            'mobile_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
            'head_name' => 'nullable|string|max:255',
            'head_mobile_number' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
        ]);
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        $firm = Firm::create($data);

        return $this->ok(new FirmResource($firm), 'Firm created.', 201);
    }

    public function show(Firm $firm): JsonResponse
    {
        return $this->ok(new FirmResource($firm));
    }

    public function update(Request $request, Firm $firm): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:firms,name,' . $firm->id,
            'address' => 'nullable|string',
            'pancard' => 'nullable|string|max:20',
            'gst' => 'nullable|string|max:20',
            'pf_code' => 'nullable|string|max:50',
            'mobile_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
            'head_name' => 'nullable|string|max:255',
            'head_mobile_number' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
        ]);
        $data['updated_by'] = Auth::id();

        $firm->update($data);

        return $this->ok(new FirmResource($firm), 'Firm updated.');
    }

    public function destroy(Firm $firm): JsonResponse
    {
        $firm->delete();

        return $this->ok(null, 'Firm deleted.');
    }
}
