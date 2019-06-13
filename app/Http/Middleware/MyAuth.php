<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if (!Auth::check())
        {
            session(['url_intended' => $request->fullUrl()]); 
            return response()->redirectToAction('AuthController@form')->with('loginRequired', true);
        }
        return $next($request);
    }
}
