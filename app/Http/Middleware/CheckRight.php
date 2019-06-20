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
        $data= [
            'method'=> $method,
            'routename' => $routeName
        ];
        $request = new \Illuminate\Http\Request($data);
        $controller= new \App\Http\Controllers\RightController();
        $routelevel=$controller->getLevel($request);

        $checkrole = new CheckRole();
        $userRole=$checkrole->privilege(Auth::user()->email);
//dd($userRole . " ". $routelevel);
        if($userRole>$routelevel||$userRole==$routelevel)return $next($request);
        return back()->with('unauthorized', true);
    }
}
