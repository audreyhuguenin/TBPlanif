<?php

namespace App\Http\Middleware;

use Closure;

class SyncNAV
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
        //sync projects with NAV
        $projectController= new \App\Http\Controllers\ProjectController();
        $syncProjects=$projectController->sync();

        //sync subtasks
        $subtaskController= new \App\Http\Controllers\SubtaskController();
        $syncSubtasks=$subtaskController->sync();
       
        //sync users
        $userController= new \App\Http\Controllers\UserController();
        $syncUsers=$userController->sync();
        
        return $next($request);
    }
}
