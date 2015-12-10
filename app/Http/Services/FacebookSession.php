<?php namespace App\Http\Services;

use Facebook\PersistentData\PersistentDataInterface;

class FacebookSession implements PersistentDataInterface {
    public function get($key)
    {
        return \Session::get('facebook.' . $key);
    }

    public function set($key, $value)
    {
        \Session::put('facebook.' . $key, $value);
    }
}