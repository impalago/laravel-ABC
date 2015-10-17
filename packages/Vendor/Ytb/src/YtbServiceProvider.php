<?php

namespace Vendor\Ytb;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;

class YtbServiceProvider extends ServiceProvider {

    /**
     * Register providers
     */
    public function register() {

        $this->mergeConfigFrom(__DIR__.'/../config/ytb.php', 'ytb');
        $app = $this->app;

        $this->app->bind('ytb', function() {
            return new Ytb;
        });

        $this->app->bind('GoogleClient', function() {
            $gClient = new \Google_Client();
            $gClient->setAccessToken(Session::get('token'));
            return $gClient;
        });

        $this->app->bind('youtube', function() use ($app) {
            $gClient = $this->app->make('GoogleClient');
            $youtube = new \Google_Service_YouTube($gClient);
            return $youtube;
        });
    }

    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/ytb.php' => config_path('ytb.php')], 'config');
        $this->loadViewsFrom(__DIR__.'/../resources/view/', 'ytb');

        require __DIR__.'/Http/routes.php';
    }

}