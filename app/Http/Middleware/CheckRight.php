<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Auth;

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
        $checkrole= new CheckRole();
        $role=$checkrole->privilege(Auth::user()->email);
        if($role!=2)
            {
            return redirect("/")->with('mustBeSuperadmin', true);
            }
        return $next($request);
    }
}
