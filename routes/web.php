<?php
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/**
 * Pour l'autocomplétion des projet, et user
 */
Route::get('projectautocomplete',array('as'=>'projectautocomplete','uses'=>'SearchController@projectautocomplete'));
Route::get('userautocomplete',array('as'=>'userautocomplete','uses'=>'SearchController@userautocomplete'));
/**
 * Retourne le formulaire de login, permet l authentification et seed la table de la DB
 */
Route::get('/auth/login', 'AuthController@form');
Route::post('/auth/check', 'AuthController@check');
Route::get('rights/seed', 'RightController@seed');

/**Middle ware d'authentification */
Route::middleware(['MyAuth'])->group(function ()
{
    Route::get('/auth/logout', 'AuthController@logout');

    /**
     * Redirections automatiques sur la home
     */
    Route::get('/', function () {
    return "Something's not working in here";
    })->middleware('checkRole');

    /**Pour l'accès à la vue de remplissage des plannings */
    Route::get('/am', function () 
    {
        $userInfo= Auth::user()->initials;
        return view('am.home', ['userInfo'=>$userInfo]);
    });

    /**Pour accéder au planning des AD, avec validation et changements */
    Route::get('/ad', function () {
        $userInfo= Auth::user()->initials;
        return view('ad.home', ['userInfo'=>$userInfo]);
    });
    
    /**Check des rights de l utilisateur, test? */
    Route::post('rights/level', 'RightController@getLevel');
    Route::resource('rights', 'RightController');
    //A chaque rechargement de page ciblant des ressources, la synchronisation des projets, sous-tâches et utilisateurs est faite.
    Route::middleware(['SyncNAV'])->group(function ()
    {

        /**
         * Différentes routes pour les accès aux controlleurs
         */
        Route::resource('tasks', 'TaskController')->middleware('checkRight');
        Route::resource('users', 'UserController')->middleware('checkRight');
        Route::get('subtasks/sync', 'SubtaskController@sync')->name('subtasks.sync')->middleware('checkRight');
        Route::get('subtasks', ['as' => 'subtasks.index', 'uses' => 'SubtaskController@index'])->middleware('checkRight');
        Route::resource('subtasks', 'SubtaskController', ['except' => ['index']])->middleware('checkRight');
        Route::get('projects/sync', 'ProjectController@sync')->name('projects.sync')->middleware('checkRight');
        Route::resource('projects', 'ProjectController')->middleware('checkRight');
        Route::get('plannings/check', 'PlanningController@check')->name('plannings.check')->middleware('checkRight');
        Route::resource('plannings', 'PlanningController')->middleware('checkRight');
        Route::post('assignations/weekplan', 'AssignationController@weekplan')->name('assignations.weekplan')->middleware('checkRight');;
        Route::post('assignations/weekplanbyuser/{id}', 'AssignationController@weekplanbyuser')->name('assignations.weekplanbyuser')->middleware('checkRight');
        Route::resource('assignations', 'AssignationController')->middleware('checkRight');
        Route::get('freedays/getbyuser/{id}', 'FreeDayController@getbyuser')->name('freedays.getbyuser')->middleware('checkRight');
        Route::resource('freedays', 'FreeDayController')->middleware('checkRight');
        Route::get('recurrentfreedays/getbyuser/{id}', 'RecFreeDayController@getbyuser')->name('recurrentfreedays.getbyuser')->middleware('checkRight');;
        Route::resource('recurrentfreedays', 'RecFreeDayController')->middleware('checkRight');
    });
});
 


