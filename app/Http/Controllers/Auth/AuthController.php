<?php

namespace App\Http\Controllers\Auth;

use App\Role;
use App\User;
use Validator;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public function __construct()
    {
        //$this->middleware('guest', ['except' => 'getLogout']);
        $this->urlSocialite = Request::segment(2);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'isActive' => isset($data['isActive']) ? 1 : 0,
        ]);
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate()
    {
        $user = \Input::all();
        if (Auth::attempt(['email' => $user['email'], 'password' => $user['password'], 'isActive' => 1])) {
            return redirect()->intended('/');
        } else {
            return redirect(route('auth.login'))->withErrors('Email or password is incorrect or the user is not active!');
        }
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        $roles = Role::all();
        return view('control-panel/users.create', ['roles' => $roles]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = $this->create($request->all());

        if ($user->id and $request->role) {
            \DB::table('role_user')->insert(
                array('role_id' => $request->role, 'user_id' => $user->id)
            );
        }

        return redirect(route('users.index'));
    }


    /**
     * Redirect the user to the Socialite authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver($this->urlSocialite)->redirect();
    }

    /**
     * Obtain the user information from Socialite.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver($this->urlSocialite)->user();
        } catch (Exception $e) {
            dd($e);
        }
        dd($user);
        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        return redirect('/');
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $facebookUser
     * @return User
     */
    private function findOrCreateUser($facebookUser)
    {
        $authUser = User::where('facebook_id', $facebookUser->id)->first();

        if ($authUser) {

            $authUser->facebook_token = $facebookUser->token;
            $authUser->save();
            return $authUser;
        }

        return User::create([
            'name' => $facebookUser->user['first_name'],
            'surname' => $facebookUser->user['last_name'],
            'email' => $facebookUser->user['email'],
            'isActive' => 1,
            'facebook_id' => $facebookUser->user['id'],
            'facebook_token' => $facebookUser->token,
            'avatar' => $facebookUser->avatar
        ]);
    }


}
