<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('1', function() { return 'Je suis la page 1 !'; });

Route::resource('user', 'UserController');
Route::resource('task', 'TaskController');
Route::resource('subtask', 'SubtaskController');
Route::resource('project', 'ProjectController');
Route::resource('planning', 'PlanningController');
Route::resource('assignation', 'AssignationController');


