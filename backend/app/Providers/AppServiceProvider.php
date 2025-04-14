<?php

namespace App\Providers;

use App\Models\TravelOrder;
use App\Observers\TravelOrderObserver;
use Illuminate\Http\Resources\Json\JsonResource;
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
        TravelOrder::observe(TravelOrderObserver::class);
        JsonResource::withoutWrapping();
    }
}
