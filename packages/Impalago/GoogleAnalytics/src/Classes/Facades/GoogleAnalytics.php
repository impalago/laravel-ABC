<?php namespace Impalago\GoogleAnalytics\Classes\Facades;

use Illuminate\Support\Facades\Facade;

class GoogleAnalytics extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'googleAnalytics';
    }
}