<?php

namespace App\Http\Controllers\Google;

use App\Http\Controllers\Controller;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Http\Services\GoogleLogin;

class GoogleLoginController extends Controller {

    protected $google;

    public function __construct(GoogleLogin $google)
    {
        $this->google = $google;
    }

    /**
     *
     * @return \Illuminagte\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function login()
    {
        if ($this->google->isLoggedIn()) {
            return redirect(route('google.index'));
        }

        $data['loginUrl'] = $this->google->getLoginUrl();
        return view('control-panel.google.login', $data);
    }

    /**
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws InvalidArgumentException
     */
    public function callback()
    {

        if (Input::has('error')) {
            dd(Input::get('error'));
        }

        if (Input::has('code')) {
            $code = Input::get('code');
            $this->google->login($code);
            return redirect(route('google.index'));
        } else {
            throw new InvalidArgumentException('The code attribute is missing');
        }
    }

    /**
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Session::forget('token');
        return redirect(route('google.login'));
    }
}