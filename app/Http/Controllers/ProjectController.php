<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource with all the plannings associated.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with('plannings')->get();
        return $projects;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);
        if (!isset($project))
        {
            return response()->json('Not found', 404);
        }      
        return $project;
    }

    
}
