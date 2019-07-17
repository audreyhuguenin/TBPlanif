<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assignation;
use Auth;
use Carbon\Carbon;

class AssignationController extends Controller
{

     /**
     * Récupère toutes les assignations pour la semaine donc la date de début et celle de fin sont données.
     * (PAS UTILISEE PAR LE FRONT) 
     *
     * @return \Illuminate\Http\Response
     */
    public function weekplan(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $assignations = Assignation::whereBetween('date', [$startDate, $endDate])->get();

        return $assignations;
    }
    /**
     * Récupère toutes les assignations pour la semaine donc la date de début et celle de fin sont données, pour l'utilisateur donné en méthode GET
     * (PAS UTILISEE PAR LE FRONT) 
     *
     * @return \Illuminate\Http\Response
     */
    public function weekplanbyuser(Request $request, $id)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $assignations = Assignation::whereBetween('date', [$startDate, $endDate])->where('user_id', $id)
        ->get();
        return $assignations;
    }

    /**
     * Récupère toutes les assignations en DB
     * (PAS UTILISEE PAR LE FRONT) 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assignations = Assignation::all();
        return $assignations;
    }

    /**
     * Crée en DB l'assignation passée en requête (PAS UTILISEE PAR LE FRONT)  
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date'=>'required|after:today',
            'duration'=>'required|lte:8',
            'type'=>'required|json',
            'suiviDA'=>'required',
            'unmovable'=>'required',
            'task_id'=>'required',
            'user_id'=>'required'
        ]);

        $assignation = new Assignation();
        $assignation->date = $request->date;
        $assignation->duration = $request->duration;
        $assignation->type = $request->type;
        $assignation->suiviDA = $request->suiviDA;
        $assignation->unmovable = $request->unmovable;
        $assignation->task_id = $request->task_id;

        $assignation->user_id = $request->user_id;
        $assignation->save();

        return response()->json($assignation, 201);
    }

    /**
     * Récupère l'assignation dont l'id est passée en paramètre GET
     * (PAS UTILISEE PAR LE FRONT) 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assignation= Assignation::find($id);
        if (!isset($assignation))
        {
            return response()->json('Not found', 404);
        }      
        return $assignation;
    }


    /**
     * Modifie l'assignation avec les données passées en paramètre de la requête 
     * (PAS UTILISEE PAR LE FRONTPOUR L?INSTANT) 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date'=>'date|after:today',
            'duration'=>'lte:8',
            'type'=>'json',
        ]);

        $assignation = Assignation::find($id);

        //test if the request asks for a changeof date, and if this date is unmovable.
        if(isset($request->date)&&$request->date!=$assignation->date&&$assignation->unmovable==true) 
        {
         //message   
        }
        elseif(isset($request->date)&&$request->date!=$assignation->date&&$assignation->unmovable==false)
        {
            $assignation->date =  $request->date;
        }

        if(isset($request->duration)) $assignation->duration =  $request->duration;
        if(isset($request->type)) $assignation->type =  $request->type;
        if(isset($request->suiviDA)) $assignation->suiviDA =  $request->suiviDA;
        if(isset($request->unmovable)) $assignation->unmovable =  $request->unmovable;
        if(isset($request->task_id)) $assignation->task_id =  $request->task_id;
        if(isset($request->user_id)) $assignation->user_id =  $request->user_id;
        
        $assignation->save();
        
        return response()->json($assignation);
        //return redirect('/assignations')->with('success', 'Assignation updated!');
    }

    /**
     * Supprime de la DB l'assignation dont l'ID est passé en paramètre
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assignation = Assignation::find($id);
        if (!isset($assignation))
        {
            return response()->json('Not found', 404);
        }     
        $assignation->delete();
        return response()->json(null, 204);

    }
     
}
