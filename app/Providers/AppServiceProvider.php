<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Client\Factory as HttpClientFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(HttpClientFactory::class, function ($app) {
            return new HttpClientFactory($app);
        });
    }
}