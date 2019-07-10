<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Planning;
use Carbon\Carbon;
use Auth;
use DB;

class PlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $now = Carbon::now()->settings([
            'locale' => 'fr_FR',
            'timezone' => 'Europe/Paris',
        ]);
        $weekNum = $now->weekOfYear;
        $startWeek= $now->startOfWeek()->format('Y-m-d H:i');
        $endweek=$now->startOfWeek()->addDays(4)->format('Y-m-d H:i');

 $tasksTest = DB::select('SELECT users.name, assignations.date, tasks.* 
from tasks 
INNER JOIN assignations ON assignations.task_id = tasks.id 
inner join users ON users.id = assignations.user_id 
WHERE assignations.date between :startDate AND :endDate
GROUP BY users.name, tasks.id', ['startDate' => $startWeek, 'endDate'=>$endweek]);

dd($tasksTest);  */

     $tasks= \App\Task::whereHas('assignations', function($query) {

            $now = Carbon::now()->settings([
                'locale' => 'fr_FR',
                'timezone' => 'Europe/Paris',
            ]);
            $weekNum = $now->weekOfYear;
            $startWeek= $now->startOfWeek()->format('Y-m-d H:i');
            $endweek=$now->startOfWeek()->addDays(4)->format('Y-m-d H:i');
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

        $userInfo= Auth::user()->initials; 

        return view('planning.demo', ['weeknum'=>$weekNum,
        'startWeek'=>$startWeek, 
        'endWeek'=>$endweek, 
        'weekDays' => $weekDays, 
        'tasks'=>$tasks,
        'userInfo'=>$userInfo]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userInfo= Auth::user()->initials; 
        $now = Carbon::now()->settings([
            'locale' => 'fr_FR',
            'timezone' => 'Europe/Paris',
        ]);
        $weekDays = array(
            $now->startOfWeek()->isoFormat('ddd D.MM'),
            $now->startOfWeek()->addDay()->isoFormat('ddd D.MM'),
            $now->startOfWeek()->addDays(2)->isoFormat('ddd D.MM'),
            $now->startOfWeek()->addDays(3)->isoFormat('ddd D.MM'),
            $now->startOfWeek()->addDays(4)->isoFormat('ddd D.MM'),
        );

        $weekDates = array(
            $now->startOfWeek()->format('Y-m-d H:i:s'),
            $now->startOfWeek()->addDay()->format('Y-m-d H:i:s'),
            $now->startOfWeek()->addDays(2)->format('Y-m-d H:i:s'),
            $now->startOfWeek()->addDays(3)->format('Y-m-d H:i:s'),
            $now->startOfWeek()->addDays(4)->format('Y-m-d H:i:s'),
        );

        $weekNum = $now->weekOfYear;
        //$assignations= \App\Assignation::whereBetween('date', [$startWeek, $endweek])->sortable()->paginate(20);
        $startWeek= $now->startOfWeek()->isoFormat('D.MM.YYYY');
        //->format('d.m.y');
        $endweek=$now->startOfWeek()->addDays(4)->isoFormat('DD.MM.YYYY');
        //->format('d.m.y');

        return view('am.create', ['userInfo'=>$userInfo, 
        'weekDays' => $weekDays, 
        'weekDates'=>$weekDates,
        'weeknum'=>$weekNum,
        'startWeek'=>$startWeek, 
        'endWeek'=>$endweek]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
dd($request);


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
