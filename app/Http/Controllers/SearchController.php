<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use App\User;


class SearchController extends Controller
{
    /**
     * Permet l'autocompltion du textarea pour la sélection du projet, 
     * sur la vue de remplisage des tâches.
     *
     * @return \Illuminate\Http\Response
     */
    public function projectautocomplete(Request $request)
    {
        $data = Project::select('number as id',"fullName as name")->where("fullName","LIKE","%{$request->input('query')}%")->get();
        return response()->json($data);
    }

    /**
     * Permet l'autcomplétion du textarea pour las sélection de l'utilisateur 
     * sur la vue du remplissage de planning
     *
     * @return \Illuminate\Http\Response
     */
    public function userautocomplete(Request $request)
    {
        $data = User::select('id',"name")->where("name","LIKE","%{$request->input('query')}%")->get();
        return response()->json($data);
    }
}