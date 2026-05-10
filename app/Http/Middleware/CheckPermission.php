<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Check against permissions.name (explicit key), not Laravel route names.
     * Usage: ->middleware('permission:dashboard.access')
     */
    public function handle(Request $request, Closure $next, string $permissionName): Response
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        if (!$user->hasPermission($permissionName)) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
