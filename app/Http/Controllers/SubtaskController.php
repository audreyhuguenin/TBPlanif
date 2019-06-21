<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subtask;
use Artisan;

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
    
/**
     * Synchronize the projects in database with NAV content.
     *
     * @return \Illuminate\Http\Response
     */
    public function sync()
    {
        Artisan::call('db:seed --class=SubtasksTableSeeder');
    }
   
}
