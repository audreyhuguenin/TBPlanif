<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Planning;
use Carbon\Carbon;

class PlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = Carbon::now();
        $weekNum = $now->weekOfYear;
        $startWeek= $now->startOfWeek()->format('Y-m-d H:i');
        //->format('d.m.y');
        $endweek=$now->endOfWeek()->format('Y-m-d H:i');
        //->format('d.m.y');

        $assignations= \App\Assignation::whereBetween('date', [$startWeek, $endweek])->sortable()->paginate(20);
        /* whereBetween('date', [$startWeek, $endweek])
        ->with('user')
        ->with('task')
        ->with('task.subtask')
        ->with('task.subtask.project')
        ->get(); */
        //->sortable()->paginate(5);
        //return $assignations;
        return view('planning.demo', ['weeknum'=>$weekNum, 'startWeek'=>$startWeek, 'endWeek'=>$endweek, 'assignations'=>$assignations]);

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
