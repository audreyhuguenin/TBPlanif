<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Auth;
use Route;
class CheckRight
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $method = $request->method();
        $routeName = $request->route()->getName();

        
        $checkrole= new CheckRole();


        dd($requestUri);
        /* $role=$checkrole->privilege(Auth::user()->email);
        if($role!=2)
            {
            return redirect("/")->with('mustBeSuperadmin', true);
            } */
        return $next($request);
    }
}
