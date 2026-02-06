<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot()
{
    Blade::if('admin', function () {
        return auth()->check() && auth()->user()->isAdmin();
    });

    Blade::if('leader', function () {
        return auth()->check() && auth()->user()->isLeader();
    });

    Blade::if('userrole', function ($roles) {
        $roles = is_array($roles) ? $roles : explode(',', $roles);
        return auth()->check() && in_array(auth()->user()->role, $roles);
    });
}

}
