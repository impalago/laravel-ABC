<?php

namespace Impalago\Ytb\Services;

use Google_Client;
use Illuminate\Support\Facades\Session;

class GoogleLogin
{
    protected $client;

    /**
     * @param Google_Client $client
     */
    public function __construct(Google_Client $client)
    {
        $this->client = $client;
        $this->client->setClientId(config('ytb.api.client_id'));
        $this->client->setClientSecret(config('ytb.api.client_secret'));
        $this->client->setDeveloperKey(config('ytb.api.api_key'));
        $this->client->setRedirectUri(config('app.url') . "/youtube/callbackLogin");
        $this->client->setScopes(config('google.google_scopes'));
        $this->client->setAccessType('offline');
    }

    /**
     * @return bool
     */
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

    /**
     * @param $code
     * @return string
     */
    public function login($code)
    {
        $this->client->authenticate($code);
        $token = $this->client->getAccessToken();
        Session::put('token', $token);
        return $token;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Session::forget('token');
    }

    /**
     * @return string
     */
    public function getLoginUrl()
    {
        $authUrl = $this->client->createAuthUrl();

        return $authUrl;
    }

}