<?php

namespace Vendor\Ytb\Http\Controllers;

use App\Http\Controllers\Controller;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Input;


class YtbController extends Controller
{

    /**
     * @param \Vendor\Ytb\Services\GoogleLogin $gl
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index(\Vendor\Ytb\Services\GoogleLogin $gl)
    {

        if ($gl->isLoggedIn()) {
            return redirect(route('ytb.index'));
        }

        $data['loginUrl'] = $gl->getLoginUrl();
        return view(config('ytb.views.login'), $data);
    }

    /**
     * @param \Vendor\Ytb\Services\GoogleLogin $gl
     */
    public function callbackLogin(\Vendor\Ytb\Services\GoogleLogin $gl)
    {

        if (Input::has('error')) {
            dd(Input::get('error'));
        }

        if (Input::has('code')) {
            $code = Input::get('code');
            $gl->login($code);
            return redirect(route('ytb.index'));
        } else {
            throw new InvalidArgumentException('The code attribute is missing');
        }
    }

    /**
     * @param \Vendor\Ytb\Services\GoogleLogin $gl
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(\Vendor\Ytb\Services\GoogleLogin $gl)
    {
        $gl->logout();
        return redirect(route('ytb.login'));
    }

}
