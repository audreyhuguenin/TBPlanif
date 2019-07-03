<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;


class SearchController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = Project::select('number as id',"fullName as name")->where("fullName","LIKE","%{$request->input('query')}%")->get();
        return response()->json($data);
    }
}