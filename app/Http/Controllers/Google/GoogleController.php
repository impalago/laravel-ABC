<?php namespace App\Http\Controllers\Google;

use App\Http\Controllers\Controller;
use App\Http\Services\GoogleLogin;

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

}