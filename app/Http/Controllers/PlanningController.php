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
     * Renvoie à la vue du planning global de la semaine en cours (CREA).
     * Retourne avec cette vue toutes les données de planification, 
     * telles que les dates de la semaine, les assignations, tâcehs et projets prévu dans ce planning.     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noww = Carbon::now()->settings([
            'locale' => 'fr_FR',
            'timezone' => 'Europe/Paris',
        ]);
        $weekNum = $noww->weekOfYear;
        $startWeek= $noww->startOfWeek()->format('Y-m-d H:i');
        $endweek=$noww->startOfWeek()->addDays(5)->format('Y-m-d H:i');

        /**
         * Requête à la DB pour récupérer toute sles ta^ches de la semaine avec leurs assignations, groupée par personne. 
         */
        $tasks= \App\Task::join('assignations', 'tasks.id', '=', 'assignations.task_id')
        ->whereBetween('date',[$startWeek, $endweek])
        ->groupBy('user_id') 
        ->select('tasks.*', 'assignations.user_id')
        ->sortable()->paginate(20);  

        $now = Carbon::now()->settings([
            'locale' => 'fr_FR',
            'timezone' => 'Europe/Paris',
        ]);
        $weekNum = $now->weekOfYear;

        $startWeek= $now->startOfWeek()->isoFormat('D.MM.YYYY');
  
        $endweekdisplayed =$now->startOfWeek()->addDays(4)->isoFormat('DD.MM.YYYY');
        $endweek=$now->startOfWeek()->addDays(5)->isoFormat('DD.MM.YYYY');

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
        'endWeekDisplayed'=>$endweekdisplayed,
        'weekDays' => $weekDays, 
        'tasks'=>$tasks,
        'userInfo'=>$userInfo]);
    }


    /**
     * Retourne la vue de remplissage du planning pour la semaine suivante. 
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
        $planning = Planning::where('weeknumber', $weekNum)->where('user_id', Auth::user()->id)->get();
        $startWeek= $now3->startOfWeek()->isoFormat('D.MM.YYYY');
        $endweek=$now->startOfWeek()->addDays(4)->isoFormat('DD.MM.YYYY');
        return view('am.create', ['userInfo'=>$userInfo, 
        'weekDays' => $weekDays, 
        'weekDates'=>$weekDates,
        'weeknum'=>$weekNum,
        'startWeek'=>$startWeek, 
        'endWeek'=>$endweek,
        'planning' => $planning]);
    }

    /**
     * Crée un objet planning persistant si l'utilisateurs n'a pas encore entré de données de planification.
     * Crée les assignations et tâches qui sont nouvellement créées.
     * Sauvegarde les changements apportés au planning rempli. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /*VALIDATION A DEVELOPPER */
        /* $request->validate([
            'sent'=>'required',
            'user_id'=>'required'
        ]); */
     
        /*Check si le planning existe déjà en DB */
        $userInfo= Auth::user()->initials; 
        $now = Carbon::now()->settings([
            'locale' => 'fr_FR',
            'timezone' => 'Europe/Paris',
        ]);
        $weekNum = $now->addDays(7)->weekOfYear;
        $existingPlanning = Planning::where('weeknumber', $weekNum)->where('user_id', Auth::user()->id)->first();
        if(count($existingPlanning)>0)
        {
            $planning = $existingPlanning;
        }
        else
        {
            $planning = new Planning();
            $planning->sent = 0;
            $planning->weeknumber = $weekNum;
            $planning->user_id = Auth::user()->id;
            $planning->save();
        }

        /* A CODER: l'update du sent à 1 lorsque l'AM envoie son planning pour validation */
        
        $projects = array();
        
        foreach ($request->project as $proj) 
        {
            array_push($projects, $proj['project_id']);
            foreach ($proj['subtask'] as $subtask)
            {                 
                foreach ($subtask['task'] as $task)
                {
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
                /* Ajoute tous les types de tâches checked à un tableau pour l'injecter en JSON en DB*/
                        $arrayType = array();
                        if(isset($assignation['typeB'])) array_push($arrayType, 'B');
                        if(isset($assignation['typeD'])) array_push($arrayType, 'D');
                        if(isset($assignation['typeRC'])) array_push($arrayType, 'RC');
                        if(isset($assignation['typePC'])) array_push($arrayType, 'PC');
                        if(isset($assignation['typeL'])) array_push($arrayType, 'L');
                        if(isset($assignation['typeRDV'])) array_push($arrayType, 'RDV');
                        if(isset($assignation['typeBO'])) array_push($arrayType, 'BO');
                        if(isset($assignation['typeRG'])) array_push($arrayType, 'RG');

                        /* Crée l'assignation et la persistante en DB */
                        $assignationToSave = new Assignation();
                        $assignationToSave->suiviDA = (isset($assignation['suiviDA'])) ? true : false;
                        $assignationToSave->unmovable = (isset($assignation['unmovable'])) ? true : false;
                        $assignationToSave->date = $assignation['date'];
                        $assignationToSave->duration = $assignation['duration'];
                        $assignationToSave->type = $arrayType;
                        $assignationToSave->task_id = $taskToSave->id;
                        $assignationToSave->user_id = $task['user'];
                        $assignationToSave->save();
                        }
                        
                    }
                  
                }
            }

        }
       $planning->projects()->sync($projects);

    /*A CODER: lien avec le planning global de l'AD, pour version 2 */
        return redirect()->route('plannings.create');
    }

    /**
     * Récupère le planning correspondant à l'ID donné
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
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
     * Modifie le planning donné pas l'ID, avec les données fournies
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
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
     * Récupère la vue de de changement et de validation du plnning global.
     * (Pour l'instant, pas très bien exploitée, retourne une simple pas "en construction", la version 2 exploitera plus cette méthode)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function check()
    {
        $noww = Carbon::now()->settings([
            'locale' => 'fr_FR',
            'timezone' => 'Europe/Paris',
        ]);
        $weekNum = $noww->addWeek()->weekOfYear;
        
        $startWeek= $noww->startOfWeek()->format('Y-m-d H:i');
        $endweek=$noww->startOfWeek()->addDays(5)->format('Y-m-d H:i');

      $tasks= \App\Task::join('assignations', 'tasks.id', '=', 'assignations.task_id')
        ->whereBetween('date',[$startWeek, $endweek])
        ->groupBy('user_id') 
        ->select('tasks.*', 'assignations.user_id')
        ->sortable()->paginate(20); 

        $weekDaysDBFormat = array(
            $noww->startOfWeek()->format('Y-m-d H:i'),
            $noww->startOfWeek()->addDay()->format('Y-m-d H:i'),
            $noww->startOfWeek()->addDays(2)->format('Y-m-d H:i'),
            $noww->startOfWeek()->addDays(3)->format('Y-m-d H:i'),
            $noww->startOfWeek()->addDays(4)->format('Y-m-d H:i'),
        );

        $durationPerDay = array();

        foreach ($weekDaysDBFormat as $day)
        {
            $assignationsDay = \App\Assignation::whereDate('date', '=', $day)->select('assignations.duration')->get();
            $durationTotal = 0;
            if(count($assignationsDay)>0)
            {
                foreach ($assignationsDay as $duration)
                {
                    $durationTotal += $duration->duration;
                    
                }
            }

            $durationPerDay[] = $durationTotal;
        }

        $now = Carbon::now()->settings([
            'locale' => 'fr_FR',
            'timezone' => 'Europe/Paris',
        ]);
        $weekNum = $now->addWeek()->weekOfYear;

        $startWeek= $now->startOfWeek()->isoFormat('D.MM.YYYY');
  
        $endweekdisplayed =$now->startOfWeek()->addDays(4)->isoFormat('DD.MM.YYYY');
        $endweek=$now->startOfWeek()->addDays(5)->isoFormat('DD.MM.YYYY');

        $weekDays = array(
            $now->startOfWeek()->isoFormat('ddd D.MM'),
            $now->startOfWeek()->addDay()->isoFormat('ddd D.MM'),
            $now->startOfWeek()->addDays(2)->isoFormat('ddd D.MM'),
            $now->startOfWeek()->addDays(3)->isoFormat('ddd D.MM'),
            $now->startOfWeek()->addDays(4)->isoFormat('ddd D.MM'),
        );

        $userInfo= Auth::user()->initials; 

        return view('ad.check', ['weeknum'=>$weekNum,
        'startWeek'=>$startWeek, 
        'endWeek'=>$endweek, 
        'endWeekDisplayed'=>$endweekdisplayed,
        'weekDays' => $weekDays, 
        'tasks'=>$tasks,
        'userInfo'=>$userInfo,
        'durationPerDay'=>$durationPerDay]);
    }

}
