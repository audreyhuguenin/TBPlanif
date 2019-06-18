<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subtask;

class SubtaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subtasks = Subtask::all();
        return $subtasks;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subtask= Subtask::find($id);
        if (!isset($subtask))
        {
            return response()->json('Not found', 404);
        }      
        return $subtask;
    }

   
}
