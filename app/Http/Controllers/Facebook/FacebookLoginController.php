<?php namespace App\Http\Controllers\Facebook;

use App\Http\Controllers\Controller;
use App\Http\Services\FacebookService;
use App\Provider;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FacebookLoginController extends Controller {

    protected $fb;

    public function __construct(FacebookService $fb)
    {
        $this->fb = $fb;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        $fb = $this->fb->getSetting();

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email', 'publish_actions', 'publish_pages', 'manage_pages', 'user_posts'];
        $loginUrl = $helper->getLoginUrl(route('facebook.callback'), $permissions);

        return view('control-panel/facebook.login', ['loginUrl' => htmlspecialchars($loginUrl)]);

    }


    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function callback()
    {
        $fb = $this->fb->getSetting();

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        if (! $accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                exit;
            }

        }
        $fb->setDefaultAccessToken((string) $accessToken);
        $user = $fb->get('/me')->getDecodedBody();

        $providerInfo = Provider::where('user_id', Auth::user()->id)
            ->where('provider', 'facebook')
            ->where('provider_id', $user['id'])->first();

        if(isset($providerInfo)) {
            Session::set('fb_access_token', $providerInfo['token']);
            Session::set('fb_id', $providerInfo['provider_id']);
        } else {
            $provider = new Provider;
            $provider->user_id = Auth::user()->id;
            $provider->provider = 'facebook';
            $provider->provider_id = $user['id'];
            $provider->token = (string) $accessToken;
            $provider->save();
            Session::set('fb_access_token', (string) $accessToken);
            Session::set('fb_id', $user['id']);
        }

        return redirect(route('facebook.index'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logout()
    {
        Session::forget('fb_access_token');
        return redirect(route('facebook.index'));
    }
}