<?php

namespace App\Providers;

use App\Sortable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param UrlGenerator $url
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if (env('REDIRECT_HTTPS')) {
            dd($url->formatScheme('https://'));
            $url->formatScheme('https://');
        }

        Schema::defaultStringLength(191);

        $this->app->bind(LengthAwarePaginator::class, \App\LengthAwarePaginator::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(Sortable::class, function ($app) {
            return new Sortable(request()->url());
        });
    }
}
