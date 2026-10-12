<?php

namespace App\Providers;

use App\Models\Advertisement;
use App\Models\SiteSetting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewInstance;

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

        View::composer('layouts.app', function (ViewInstance $view): void {
            $showHomepageBikramSambatDate = SiteSetting::homepageBikramSambatDateEnabled();

            $view->with('showHomepageBikramSambatDate', $showHomepageBikramSambatDate);
            $view->with(
                'homepageHeaderAdvertisements',
                $showHomepageBikramSambatDate || request()->routeIs('admin.*')
                    ? new Collection
                    : Advertisement::homepageHeaderBanners(),
            );
        });
    }
}
