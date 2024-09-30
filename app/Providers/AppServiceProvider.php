<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use App\Models\Property;
use App\Observers\PropertyObserver;
use Illuminate\Support\Facades\Gate;

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

        Vite::prefetch(concurrency: 3);
        Property::observe(PropertyObserver::class);

        Gate::define('manage-imoveis', function ($user) {
            return $user->role === 'corretor';
        });


    }
}
