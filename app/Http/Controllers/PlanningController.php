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
    $tasks= \App\Task::whereHas('assignations', function($query) {

            $now = Carbon::now()->settings([
                'locale' => 'fr_FR',
                'timezone' => 'Europe/Paris',
            ]);
            $weekNum = $now->weekOfYear;
            $startWeek= $now->startOfWeek()->format('Y-m-d H:i');
            $endweek=$now->endOfWeek()->format('Y-m-d H:i');
        $query->whereBetween('date',[$startWeek, $endweek]);
        })
        ->sortable()->paginate(20);

        $now = Carbon::now()->settings([
            'locale' => 'fr_FR',
            'timezone' => 'Europe/Paris',
        ]);
        $weekNum = $now->weekOfYear;
        //$assignations= \App\Assignation::whereBetween('date', [$startWeek, $endweek])->sortable()->paginate(20);
        $startWeek= $now->startOfWeek()->isoFormat('D.MM.YYYY');
        //->format('d.m.y');
        $endweek=$now->startOfWeek()->addDays(4)->isoFormat('DD.MM.YYYY');
        //->format('d.m.y');

        $weekDays = array(
            $now->startOfWeek()->isoFormat('ddd D.MM'),
            $now->startOfWeek()->addDay()->isoFormat('ddd D.MM'),
            $now->startOfWeek()->addDays(2)->isoFormat('ddd D.MM'),
            $now->startOfWeek()->addDays(3)->isoFormat('ddd D.MM'),
            $now->startOfWeek()->addDays(4)->isoFormat('ddd D.MM'),
    );

        return view('planning.demo', ['weeknum'=>$weekNum,
        'startWeek'=>$startWeek, 
        'endWeek'=>$endweek, 
        'weekDays' => $weekDays, 
        'tasks'=>$tasks]);

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
