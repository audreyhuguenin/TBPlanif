<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    /**
     * Récupère toutes les tâches en DB
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        return $tasks;
    }

    /**
     * Crée une nouvelle tâceh en DB avec les données fournies
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|max:255',
        ]);
        
        $task = new Task();
        $task->name = $validated->name;
        $task->comment = $validated->comment;
        $task->subtask_id = $validated->subtask_id;  
        $task->save();
        return response()->json($task, 201);

    }

    /**
     * Récupère la tâche dont l'ID est donné
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task= Task::find($id);
        if (!isset($task))
        {
            return response()->json('Not found', 404);
        }      
        return $task;
    }

    /**
     * Modifie la tâche choisie avec les données fournies
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'max:255'
        ]);

        $task = Task::find($id);
        $task->name =  $request->name;
        if(isset($request->comment))$task->comment = $request->comment;
        $task->save();
        return response()->json($task);
    }

    /**
     * Supprime de la DB la tâceh choisie.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if (!isset($task))
        {
            return response()->json('Not found', 404);
        }     
        $task->delete();
        return response()->json(null, 204);

    }
}
