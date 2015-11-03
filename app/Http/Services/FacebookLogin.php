<?php
namespace App\Http\Services;

use Facebook\Facebook;

class FacebookLogin
{

    /**
     * @return Facebook
     */
    public function getSetting()
    {
        $fb = new Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v2.5',
        ]);
        return $fb;
    }

}