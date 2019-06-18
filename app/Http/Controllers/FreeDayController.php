<?php

namespace App\Http\Controllers;

use App\FreeDay;
use Illuminate\Http\Request;

class FreeDayController extends Controller
{
/**
     * Display the specified resource.
     *
     */
    public function getbyuser($id)
    { 
        $freedays = FreeDay::where('user_id', $id)
        ->get();
        
        return $freedays;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $freedays = FreeDay::all();
        return $freedays;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'startDate'=>'required',
            'endDate'=>'required',
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
     * Display the specified resource.
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\FreeDay  $freeDay
     * @return \Illuminate\Http\Response
     */
    public function edit(FreeDay $freeDay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FreeDay  $freeDay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $day = FreeDay::find($id);

        if(isset($request->startDate)) $day->startDate =  $request->startDate;
        if(isset($request->endDate)) $day->endDate =  $request->endDate;
        if(isset($request->user_id)) $day->user_id =  $request->user_id;
        
        $day->save();
        
        return response()->json($day);
    }

    /**
     * Remove the specified resource from storage.
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
