<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
    public function boot(): void
    {
        // Register icon components manually for dynamic usage
        Blade::component('components.icons.users', 'icon-users');
        Blade::component('components.icons.clipboard-list', 'icon-clipboard-list');
        Blade::component('components.icons.user-check', 'icon-user-check');
        Blade::component('components.icons.bookmark-alt', 'icon-bookmark-alt');
        Blade::component('components.icons.check-circle', 'icon-check-circle');
        Request::setTrustedProxies(['*'], Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_HOST | Request::HEADER_X_FORWARDED_PORT | Request::HEADER_X_FORWARDED_PROTO);
    }
}
