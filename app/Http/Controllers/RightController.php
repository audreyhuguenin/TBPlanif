<?php

namespace App\Http\Controllers;

use App\Right;
use Illuminate\Http\Request;
use Illuminate\Database\Seeder;
use App\Database\Seeds\RightsTableSeeder;
use Artisan;

class RightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rights = Right::all();
        return $rights;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $right= Right::find($id);
        if (!isset($right))
        {
            return response()->json('Not found', 404);
        }      
        return $right;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'method'=>'required',
            'routename'=>'required',
            'level'=>'required',
        ]);

        $right = new Right();
        $right->method = $request->method;
        $right->routename = $request->routename;
        $right->level = $request->level;
        $right->save();
        return response()->json($right, 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'method'=>'required',
            'routename'=>'required',
            'level'=>'required',
        ]);

        $right = Task::find($id);
        $right->method =  $request->method;
        $right->routename = $request->routename;
        $right->level = $request->level;
        $right->save();
        return response()->json($right);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLevel(Request $request)
    {
        $right = Right::where(
                [
                    ['method', $request->method],
                    ['routename', $request->routename],
                ]
        )->first();
        return $right->level;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seed()
    {
        Artisan::call('db:seed --class=RightsTableSeeder');
    }

}
