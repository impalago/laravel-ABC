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
use App\Provider;
use Illuminate\Http\Request;

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

    protected $redirectTo = '/control';

    public function __construct()
    {
        //$this->middleware('guest', ['except' => 'getLogout']);
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
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/control';
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
     * @param $provider
     * @return mixed
     */
    public function redirectToProvider($provider)
    {
        if(count(config($provider.'.'.$provider.'_scopes'))){
            return Socialite::driver($provider)->scopes(config($provider.'.'.$provider.'_scopes'))->redirect();
        } else {
            return Socialite::driver($provider)->redirect();
        }
    }

    /**
     * Obtain the user information from Socialite.
     *
     * @param $provider
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect(route('auth.login'));
        }

        $authUser = $this->findOrCreateUser($user, $provider);

        Auth::login($authUser, true);

        return redirect(route($provider.'.index'));
    }

    /**
     * Return user if exists; create and return if doesn't
     * Create provider or ret
     *
     * @param $providerUser
     * @param $provider
     * @return User
     */
    private function findOrCreateUser($providerUser, $provider)
    {

        $providerId = $providerUser->getId();

        if (Auth::check()) {
            $userId = Auth::user()->id;
            $authProvider = Provider::where('provider', $provider)
                ->where('provider_id', $providerId)
                ->where('user_id', $userId)->first();

            if (!$authProvider) {
                Provider::create([
                    'user_id' => $userId,
                    'provider' => $provider,
                    'provider_id' => $providerId,
                    'token' => $providerUser->token
                ]);
            }

            return User::find($userId);
        }

        $authProvider = Provider::where('provider', $provider)->where('provider_id', $providerId)->first();

        if ($authProvider and !Auth::check()) {

            $authProvider->token = $providerUser->token;
            $authProvider->save();
            return User::find($authProvider['user_id']);
        }

        $user = User::find($authProvider['user_id']);

        if ($user or Auth::check()) {
            $userId = $user['id'];
        } else {
            $newUser = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'isActive' => 1,
                'avatar' => $providerUser->getAvatar()
            ]);
            $userId = $newUser->id;
        }

        Provider::create([
            'user_id' => $userId,
            'provider' => $provider,
            'provider_id' => $providerId,
            'token' => $providerUser->token
        ]);

        return User::find($userId);
    }


}
