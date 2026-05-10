<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    
    public function register(): void
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('hasPermission', function (string $permissionName): bool {
            $user = Auth::user();

            return $user ? $user->hasPermission($permissionName) : false;
        });

        Blade::if('hasRole', function (string $roleName): bool {
            $user = Auth::user();

            return $user ? $user->hasRole($roleName) : false;
        });
    }
}
