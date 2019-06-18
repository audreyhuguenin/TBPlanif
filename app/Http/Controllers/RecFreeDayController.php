<?php

namespace App\Http\Controllers;

use App\RecurrentFreeDay;
use Illuminate\Http\Request;
use App\User;

class RecFreeDayController extends Controller
{

    /**
     * Display a listing of the recfreedays for a given user.
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recfreedays = RecurrentFreeDay::all();
        return $recfreedays;
    }

    /**
     * Display the specified resource.
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
