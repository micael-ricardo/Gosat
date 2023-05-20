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
        $this->app->singleton('Illuminate\Contracts\Events\Dispatcher', function ($app) {
            return new \Illuminate\Events\Dispatcher($app);
        });
        $this->app->singleton('Illuminate\Http\Client\Factory', function ($app) {
            return new \Illuminate\Http\Client\Factory($app->make('Illuminate\Contracts\Events\Dispatcher'));
        });
    }
}