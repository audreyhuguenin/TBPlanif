<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Artisan;

class UserController extends Controller
{
    /**
     * Récupère tous les utilisateurs en DB
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    /**
     * Récupère l'utilisateur dont l'ID est donné
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!isset($user))
        {
            return response()->json('Not found', 404);
        }      
        return $user;
    }

    /**
     * Montre le formulaire de modification des données de l'utilisateur
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // A CODER
    }

    /**
     * Modifie l'utilisateur choisi avec les données fournies
     * (PAS UTILISE PAR LE FRONT POUR L INSTANT)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
           'contractRate'=>'required, lt:120'
       ]);
       
       $user = User::find($id);
       
       $user->contractRate =  $request->contractRate;
       $user->save();
       return response()->json($user);
    }

    /**
     * Synchronise les utilisateurs en DB avec le contenu de NAV dynamics
     *
     * @return \Illuminate\Http\Response
     */
    public function sync()
    {
        Artisan::call('db:seed --class=UsersTableSeeder');
    }

}
