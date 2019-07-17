<?php

namespace App\Http\Controllers;

use App\FreeDay;
use Illuminate\Http\Request;
use Auth;

class FreeDayController extends Controller
{
/**
     *Récupère tous les jour de congés d'un utilisateurs donné (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     */
    public function getbyuser($id)
    { 
        $freedays = FreeDay::where('user_id', $id)
        ->get();
        
        return $freedays;
    }
    /**
     * Récupère tous les jours de congé (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $freedays = FreeDay::all();
        $userInfo= Auth::user()->initials; 
        return view('ad.freedays', ['userInfo'=>$userInfo, 'freeDays'=>$freedays]);
    }

    /**
     *Montre le formulaire de création d'un jour de congé (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Sauvegarde en DB le nouveau jour de congé
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'startDate'=>'required|date|before:endDate',
            'endDate'=>'required|date',
            'user_id'=>'required'
        ]);

        $day = new FreeDay();
        $day->startDate = $request->startDate;
        $day->endDate = $request->endDate;
        $day->user_id = $request->user_id;
        $day->save();

        return response()->json($day, 201);
    }

    /**
     * Montre le jour de congé dont l'ID est donné
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @param  \App\FreeDay  $freeDay
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $day= FreeDay::find($id);
        if (!isset($day))
        {
            return response()->json('Not found', 404);
        }      
        return $day;
    }

    /**
     * Montre le formulaire de modification de jour de congé
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @param  \App\FreeDay  $freeDay
     * @return \Illuminate\Http\Response
     */
    public function edit(FreeDay $freeDay)
    {
        //
    }

    /**
     * Modifie le jour de congé donné avec les nouvelles données transmises
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FreeDay  $freeDay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'startDate'=>'date|before:endDate',
            'endDate'=>'date',
        ]);
        $day = FreeDay::find($id);

        if(isset($request->startDate)) $day->startDate =  $request->startDate;
        if(isset($request->endDate)) $day->endDate =  $request->endDate;
        if(isset($request->user_id)) $day->user_id =  $request->user_id;
        
        $day->save();
        
        return response()->json($day);
    }

    /**
     * Supprime de la DB le jour de congé dont l'ID est donné
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @param  \App\FreeDay  $freeDay
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $day = FreeDay::find($id);
        if (!isset($id))
        {
            return response()->json('Not found', 404);
        }     
        $day->delete();
        return response()->json(null, 204);
    }
}
