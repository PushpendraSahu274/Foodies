<?php

namespace App\Providers;

use App\Http\Middleware\RoleMiddleware;
use App\Models\Cart;
use App\Observers\Cart\CartObserver;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
        Cart::observe(CartObserver::class);
        Route::aliasMiddleware('role', RoleMiddleware::class);
    }
}
