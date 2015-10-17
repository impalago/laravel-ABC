<?php

namespace Vendor\Ytb;

use Illuminate\Support\ServiceProvider;

class YtbServiceProvider extends ServiceProvider {

    public function register() {

        $this->mergeConfigFrom(__DIR__.'/../config/ytb.php', 'ytb');

        $this->app->bind('ytb', function() {
            return new Ytb;
        });
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/ytb.php' => config_path('ytb.php')], 'config');
        $this->loadViewsFrom(__DIR__.'/../resources/view/', 'ytb');

        require __DIR__.'/Http/routes.php';
    }

}