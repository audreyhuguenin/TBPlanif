<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use Artisan;

class ProjectController extends Controller
{
    /**
     * Récupère tous les projets en DB
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with('plannings')->get();
        return $projects;
    }

    /**
     * Récupère le projet dont l'ID est donné
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
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

    /**
     * Synchronise les projets en DB avec le contenu présent sur NAV
     *
     * @return \Illuminate\Http\Response
     */
    public function sync()
    {
        Artisan::call('db:seed --class=ProjectsTableSeeder');
    }

    
}
