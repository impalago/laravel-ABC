<?php namespace App\Http\Controllers\Google;

use App\Http\Controllers\Controller;
use App\Http\Services\GoogleLogin;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Input;

class GoogleController extends Controller
{

    protected $google;

    public function __construct(GoogleLogin $google)
    {
        $this->google = $google;
    }

    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index()
    {
        if ($this->google->isLoggedIn()) {
            return view('control-panel.google.index');
        }

        return redirect(route('google.login'));
    }

    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
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
    public function callbackLogin()
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
        $this->google->logout();
        return redirect(route('google.login'));
    }
}