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
     * Récupère tous les droits présents en DB
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rights = Right::all();
        return $rights;
    }
    /**
     * Récupère le droit dont l'ID est donné
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
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
     * Crée en DBun nouveau droit avec les données fournies
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
     * Modifie le droit existant en DB avec les données fournies
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
     * Récupère le droit dont la méthode et le nom de la route correspondent à ceux entrés en paramètre. 
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
     * Effectue un seed de la base de données avec le contenu du fichier de seeding. 
     *
     * @return \Illuminate\Http\Response
     */
    public function seed()
    {
        Artisan::call('db:seed --class=RightsTableSeeder');
    }

}
