<?php

namespace App\Providers;

use App\Models\Advertisement;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
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
        if ($this->app->environment('production') || str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        View::composer('layouts.app', function ($view): void {
            if (request()->routeIs('home', 'admin.*')) {
                return;
            }

            $currentTime = now();
            $headerAdvertisements = Advertisement::query()
                ->where('position', 'header')
                ->where('active', true)
                ->where(function ($query) use ($currentTime) {
                    $query->whereNull('starts_at')
                        ->orWhere('starts_at', '<=', $currentTime);
                })
                ->where(function ($query) use ($currentTime) {
                    $query->whereNull('ends_at')
                        ->orWhere('ends_at', '>=', $currentTime);
                })
                ->latest()
                ->get();

            $view->with('sharedHeaderAdvertisements', $headerAdvertisements);
        });
    }
}
