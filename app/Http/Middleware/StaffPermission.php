<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class StaffPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isStaff()) {
            // Staff can only access limited routes
            $allowedRoutes = [
                'admin.dashboard',
                'daily-expense.index',
                'daily-expense.create',
                'daily-expense.store',
                'daily-expense.edit',
                'daily-expense.update',
                'daily-expense.destroy',
                'user.getProfile',
                'user.editProfile',
                'user.updateProfile',
                'user.changePassword',
                'user.updatePassword',
                'logout',
            ];

            $routeName = $request->route()->getName();
            
            if (!in_array($routeName, $allowedRoutes)) {
                abort(403, 'Access denied. You do not have permission to access this page.');
            }
        }

        return $next($request);
    }
}
