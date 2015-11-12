<?php namespace Impalago\GoogleAnalytics;

use Google_Client;
use Illuminate\Support\ServiceProvider;
use Impalago\GoogleAnalytics\Classes\GoogleAnalytics;


class GoogleAnalyticsServiceProvider extends ServiceProvider
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
     *
     */
    public function register()
    {

        $this->app->bind('googleAnalytics', function() {
            return new GoogleAnalytics;
        });
    }

}
