<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\Middleware;

/**
 * Base class for all mobile API controllers.
 * Provides a single consistent JSON envelope: { success, message, data }
 * and a helper to wire per-action RBAC against the permissions.name keys.
 */
abstract class ApiController extends Controller
{
    protected function ok($data = null, ?string $message = null, int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    protected function fail(string $message, int $status = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $status);
    }

    /**
     * Per-action permission middleware mapped to the existing permissions.name
     * convention: "<resource>.index|show|store|update|destroy".
     *
     * Used by each module controller's static middleware() (HasMiddleware):
     *   public static function middleware(): array
     *   { return self::permissionMiddleware('departments'); }
     */
    protected static function permissionMiddleware(string $resource): array
    {
        return [
            new Middleware("permission:{$resource}.index",   only: ['index']),
            new Middleware("permission:{$resource}.show",    only: ['show']),
            new Middleware("permission:{$resource}.store",   only: ['store']),
            new Middleware("permission:{$resource}.update",  only: ['update']),
            new Middleware("permission:{$resource}.destroy", only: ['destroy']),
        ];
    }
}
