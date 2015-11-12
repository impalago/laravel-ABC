<?php

namespace App\Http\Middleware;

use App\Http\Services\GoogleLogin;
use Closure;

class GoogleMiddleware
{

    protected $google;

    /**
     * @param GoogleLogin $google
     */
    public function __construct(GoogleLogin $google) {
        $this->google = $google;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->google->isLoggedIn()) {
            return redirect(route('google.login'));
        }

        return $next($request);
    }
}
