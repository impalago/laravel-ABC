<?php

namespace App\Providers;

use Google_Client;
use Google_Service_Analytics;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;
        $this->app->bind('GoogleClient', function() {
            $gClient = new Google_Client();
            $gClient->setAccessToken(Session::get('token'));
            return $gClient;
        });

        $this->app->bind('analytics', function() use ($app) {

            $gClient = $this->app->make('GoogleClient');
            $analytics = new Google_Service_Analytics($gClient);
            return $analytics;
        });
    }
}
