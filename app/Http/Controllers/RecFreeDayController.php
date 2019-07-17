<?php

namespace App\Http\Controllers;

use App\RecurrentFreeDay;
use Illuminate\Http\Request;
use App\User;

class RecFreeDayController extends Controller
{

    /**
     * Récupère tous les jours de congés récurrents (jours de la semaine) pour un user dont l'id est donné
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @return \Illuminate\Http\Response
     */
    public function getbyuser($id)
    {
        $user= User::find($id);
        $days= $user->recurrentfreedays;
        return $days;
    }

    /**
     * Récupère tous les jours de congés disponibles en DB
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recfreedays = RecurrentFreeDay::all();
        return $recfreedays;
    }

    /**
     * récupères le jours de congé dont l'ID est donné
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @param  \App\RecurrentFreeDay  $recurrentFreeDay
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $day= RecurrentFreeDay::find($id);
        if (!isset($day))
        {
            return response()->json('Not found', 404);
        }      
        return $day;
    }
}
