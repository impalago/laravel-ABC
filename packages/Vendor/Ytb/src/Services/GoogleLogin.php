<?php

namespace Vendor\Ytb\Services;

use Illuminate\Support\Facades\Session;

class GoogleLogin {
    protected $client;

    public function __construct(\Google_Client $client)
    {
        $this->client = $client;

        $this->client->setClientId(config('ytb.api.client_id'));
        $this->client->setClientSecret(config('ytb.api.client_secret'));
        $this->client->setDeveloperKey(config('ytb.api.api_key'));
        $this->client->setRedirectUri(config('app.url')."/ytb/callbackLogin");
        $this->client->setScopes([
            'https://www.googleapis.com/auth/youtube',
        ]);
        $this->client->setAccessType('offline');
    }

    public function isLoggedIn()
    {
        if (Session::has('token')) {
            $this->client->setAccessToken(Session::get('token'));
        }

        if ($this->client->isAccessTokenExpired()) {
            Session::set('token', $this->client->getRefreshToken());
        }

        return !$this->client->isAccessTokenExpired();
    }

    public function login($code)
    {
        $this->client->authenticate($code);
        $token = $this->client->getAccessToken();
        Session::put('token', $token);

        return $token;
    }

    public function getLoginUrl()
    {
        $authUrl = $this->client->createAuthUrl();

        return $authUrl;
    }

}