<?php

namespace App\Providers;

use App\Services\CurrencyService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CurrencyService::class, function (Application $app) {
            $config = $app['config']['services']['currencies'];
            return new CurrencyService($config['get_currencies_url']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
