<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Planning;

class PlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plannings = Planning::all();
        return $plannings;
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
            'sent'=>'required',
            'user_id'=>'required'
        ]);

        $planning = new Planning();
        $planning->sent = $request->sent;
        $planning->user_id = $request->user_id;
        if(isset($request->parent_id))$planning->parent_id = $request->parent_id;
        $planning->save();
        return response()->json($planning, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $planning = Planning::find($id);
        if (!isset($planning))
        {
            return response()->json('Not found', 404);
        }      
        return $planning;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'sent'=>'required'
        ]);

        $planning = Planning::find($id);
        $planning->sent =  $request->sent;
        $planning->save();
        return response()->json($planning);
    }

}
