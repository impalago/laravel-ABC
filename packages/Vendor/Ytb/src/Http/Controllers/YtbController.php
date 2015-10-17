<?php

namespace Vendor\Ytb\Http\Controllers;

use App\Http\Controllers\Controller;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Input;


class YtbController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param \Vendor\Ytb\Services\GoogleLogin $gl
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index(\Vendor\Ytb\Services\GoogleLogin $gl) {

        if($gl->isLoggedIn()) {
            return redirect('ytb');
        }

        $data['loginUrl'] = $gl->getLoginUrl();

        return view(config('ytb.views.login'), $data);
    }

    public function callbackLogin(\Vendor\Ytb\Services\GoogleLogin $gl) {

        if(Input::has('error')) {
            dd(Input::get('error'));
        }

        if(Input::has('code')) {
            $code = Input::get('code');
            $gl->login($code);

            echo 111;
        } else {
            throw new InvalidArgumentException('The code attribute is missing');
        }
    }

    public function getListVideo (){
        return view(config('ytb.views.list'));
    }

}
