<?php

return [
    'views' => [
        'layout' => 'ytb::layout.default',
        'login' => 'ytb::login',
        'list' => 'ytb::list',
        'video' => 'ytb::video'
    ],
    'sections' => [
        'content' => 'content',
    ],
    'api' => [
        'app_name' => config('google.api.app_name'),
        'client_id' => config('google.api.client_id'),
        'client_secret' => config('google.api.client_secret'),
        'api_key' => config('google.api.api_key')
    ]
];