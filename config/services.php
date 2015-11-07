<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
        'client_id' => '837932846324265',
        'client_secret' => 'ed10e5a5d9ca5f01f4f30969c878e5eb',
        'redirect' => 'http://localhost/auth/facebook/callback',
    ],
    'google' => [
        'client_id' => '12210675764-8ffn7gko02co6vee4oo68iajc8l2o51f.apps.googleusercontent.com',
        'client_secret' => 'ZF3AjO8F8wh5_AtBeIt4qY1E',
        'redirect' => 'http://localhost/auth/google/callback',
    ]

];
