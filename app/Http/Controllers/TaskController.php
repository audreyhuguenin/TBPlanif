<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $tasks = Task::all();
        return $tasks;
        //return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //task.
            'name'=>'required|max:255',

            //if min. 1 assignation ok
        ]);
        
        $task = new Task();
        $task->name = $validated->name;
        $task->comment = $validated->comment;
        $task->subtask_id = $validated->subtask_id;  
        $task->save();
        return response()->json($task, 201);
       //return redirect('/tasks')->with('success', 'Task saved!');
    }

    /**
     * Display the specified resource.
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        return view('tasks.edit', compact('task'));
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
            'name'=>'max:255'
        ]);

        $task = Task::find($id);
        $task->name =  $request->name;
        if(isset($request->comment))$task->comment = $request->comment;
        $task->save();
        return response()->json($task);
        //return redirect('/tasks')->with('success', 'Task updated!');
    }

    /**
     * Remove the specified resource from storage.
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

        //return redirect('/tasks')->with('success', 'Task deleted!');
    }
}
