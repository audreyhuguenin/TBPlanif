<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subtask;
use Artisan;

class SubtaskController extends Controller
{
    /**
     * Récupère toutes les sous-tâche présentes en DB.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subtasks= Subtask::where('project_id', $request->project_id)->get();
        return $subtasks;
    }


    /**
     * Récupère la sous-tâche dont l'ID est donnée 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subtask= Subtask::find($id);
        if (!isset($subtask))
        {
            return response()->json('Not found', 404);
        }      
        return $subtask;
    }
    
/**
     * Synchronise les projects en DB avec l'ERP NAVdynamics
     *
     * @return \Illuminate\Http\Response
     */
    public function sync()
    {
        Artisan::call('db:seed --class=SubtasksTableSeeder');
    }
   
}
