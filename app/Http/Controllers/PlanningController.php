<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Planning;
use App\Assignation;
use App\Task;
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
            $now->startOfWeek()->addDays(7)->isoFormat('ddd D.MM'),
            $now->startOfWeek()->addDay()->isoFormat('ddd D.MM'),
            $now->startOfWeek()->addDays(2)->isoFormat('ddd D.MM'),
            $now->startOfWeek()->addDays(3)->isoFormat('ddd D.MM'),
            $now->startOfWeek()->addDays(4)->isoFormat('ddd D.MM'),
        );
        $now2 = Carbon::now()->settings([
            'locale' => 'fr_FR',
            'timezone' => 'Europe/Paris',
        ]);
        $weekDates = array(
            $now2->startOfWeek()->addDays(7)->format('Y-m-d H:i:s'),
            $now2->startOfWeek()->addDay()->format('Y-m-d H:i:s'),
            $now2->startOfWeek()->addDays(2)->format('Y-m-d H:i:s'),
            $now2->startOfWeek()->addDays(3)->format('Y-m-d H:i:s'),
            $now2->startOfWeek()->addDays(4)->format('Y-m-d H:i:s'),
        );

        $now3 = Carbon::now()->settings([
            'locale' => 'fr_FR',
            'timezone' => 'Europe/Paris',
        ]);
        $weekNum = $now3->addDays(7)->weekOfYear;
        //$assignations= \App\Assignation::whereBetween('date', [$startWeek, $endweek])->sortable()->paginate(20);
        $startWeek= $now3->startOfWeek()->isoFormat('D.MM.YYYY');
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

        //VALIDATION A REVOIR
        /* $request->validate([
            'sent'=>'required',
            'user_id'=>'required'
        ]); */

//Première sauvgarde: création du planning, mettre le user_id de l'AM dedans, sent -> 0
//aller chercher si ce planning n'existe pas déjà, pour les memes dates et le meme user.

            /* $tasks= \App\Task::whereHas('assignations', function($query) {

                $now = Carbon::now()->settings([
                    'locale' => 'fr_FR',
                    'timezone' => 'Europe/Paris',
                ]);
                $weekNum = $now->weekOfYear;
                $startWeek= $now->startOfWeek()->format('Y-m-d H:i');
                $endweek=$now->startOfWeek()->addDays(4)->format('Y-m-d H:i');
            $query->whereBetween('date',[$startWeek, $endweek]);
            })->get();
            
            dd($tasks[1]->subtask->project->plannings);
            //dd($tasks[0]->subtask->project->plannings);
            $planif = DB::table('plannings')
            ->join('projects', 'users.id', '=', 'contacts.user_id')->where('user_id', Auth::user()->id)->get(); */

        $planning = new Planning();
        $planning->sent = 0;
        $planning->user_id = Auth::user()->id;
        $planning->save();
        $projects = array();
        
        foreach ($request->project as $proj) 
        {
            array_push($projects, $proj['project_id']);
            foreach ($proj['subtask'] as $subtask)
            {                 
                foreach ($subtask['task'] as $task)
                {
                    
                    $isThereAssignation = false;
                    $taskToSave = new Task();
                    $taskToSave->name = $task['task_name'];
                    if(isset($task['comment']))$taskToSave->comment = $task['comment'];
                    $taskToSave->subtask_id = $subtask['subtask_id'];
                    $taskToSave->save();
                    

                    foreach ($task['assignations'] as $assignation)
                    {

                        if(count($assignation) <= 2 && is_null($assignation['duration']))
                        {
                            continue;
                        }
                        else
                        {

                        $isThereAssignation = true;
                            /* Add checked assignation types to a the Type Table to inject it as JSON in DB */
                        $arrayType = array();
                        if(isset($assignation['typeB'])) array_push($arrayType, 'B');
                        if(isset($assignation['typeD'])) array_push($arrayType, 'D');
                        if(isset($assignation['typeRC'])) array_push($arrayType, 'RC');
                        if(isset($assignation['typePC'])) array_push($arrayType, 'PC');
                        if(isset($assignation['typeL'])) array_push($arrayType, 'L');
                        if(isset($assignation['typeRDV'])) array_push($arrayType, 'RDV');
                        if(isset($assignation['typeBO'])) array_push($arrayType, 'BO');
                        if(isset($assignation['typeRG'])) array_push($arrayType, 'RG');


                        /* Create Assignation object to save it in DB */
                        $assignationToSave = new Assignation();
                        $assignationToSave->suiviDA = (isset($assignation['suiviDA'])) ? true : false;
                        $assignationToSave->unmovable = (isset($assignation['unmovable'])) ? true : false;
                        $assignationToSave->date = $assignation['date'];
                        $assignationToSave->duration = $assignation['duration'];
                        $assignationToSave->type = $arrayType;
                        $assignationToSave->task_id = $taskToSave->id;
                        $assignationToSave->user_id = $task['user'];
                        $assignationToSave->save();
                        //if(!$isThereAssignation) dd('holà');

                        }
                        
                    }

                    
                }
            }

        }
        $planning->projects()->sync($projects);

        /*A CODER: lien avec le planning global de l'AD, pour version 2 */
        //if(isset($request->parent_id))$planning->parent_id = $request->parent_id;

        
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


    /**
     * Get the view of the Account Director, for her/him to check the global planning
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function check()
    {
        $userInfo= Auth::user()->initials; 
        return view('ad.check', ['userInfo'=>$userInfo]);
    }

}
