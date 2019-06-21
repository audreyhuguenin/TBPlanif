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

Route::get('/auth/login', 'AuthController@form');
Route::post('/auth/check', 'AuthController@check');
Route::get('users/sync', 'UserController@sync')->name('users.sync');
Route::get('rights/seed', 'RightController@seed');

Route::middleware(['MyAuth'])->group(function ()
{
    Route::get('/auth/logout', 'AuthController@logout');
    Route::get('/secure', function ()
    {
        return Auth::user()->email . ' access granted';
    });


    Route::get('/', function () {
    return "Something's not working in here";
    })->middleware('checkRole');

    Route::get('/planif', function () {
    return "CREA";
    });
    Route::get('/am', function () {
    return "AM accueil";
    });
    Route::get('/ad', function () {
    return "AD accueil";
    });

    Route::get('sync', function () {
    $syncprojects= new ProjectsTableSeeder();
    $syncprojects->run();
    $syncsubtasks= new SubtasksTableSeeder();
    $syncsubtasks->run();
    $syncusers= new UsersTableSeeder();
    $syncusers->run(); 
    
    return 'synchronized';
    })->middleware('checkRight');
    
    
    Route::post('rights/level', 'RightController@getLevel');
    Route::resource('rights', 'RightController');


    Route::resource('tasks', 'TaskController')->middleware('checkRight');
    Route::resource('users', 'UserController')->middleware('checkRight');
    Route::get('subtasks/sync', 'SubtaskController@sync')->name('subtasks.sync')->middleware('checkRight');
    Route::resource('subtasks', 'SubtaskController')->middleware('checkRight');
    Route::get('projects/sync', 'ProjectController@sync')->name('projects.sync')->middleware('checkRight');
    Route::resource('projects', 'ProjectController')->middleware('checkRight');
    Route::resource('plannings', 'PlanningController')->middleware('checkRight');
    Route::post('assignations/weekplan', 'AssignationController@weekplan')->name('assignations.weekplan')->middleware('checkRight');;
    Route::post('assignations/weekplanbyuser/{id}', 'AssignationController@weekplanbyuser')->name('assignations.weekplanbyuser')->middleware('checkRight');
    Route::resource('assignations', 'AssignationController')->middleware('checkRight');
    Route::get('freedays/getbyuser/{id}', 'FreeDayController@getbyuser')->name('freedays.getbyuser')->middleware('checkRight');
    Route::resource('freedays', 'FreeDayController')->middleware('checkRight');
    Route::get('recurrentfreedays/getbyuser/{id}', 'RecFreeDayController@getbyuser')->name('recurrentfreedays.getbyuser')->middleware('checkRight');;
    Route::resource('recurrentfreedays', 'RecFreeDayController')->middleware('checkRight');

});



    
    


//
//Route::get('navlogin', function() {
//
//
//        try {
//            $options = [
//                'soap_version' => SOAP_1_1,
//                'connection_timeout' => 120,
//                'login' => env('NAV_LOGIN'),
//                'password' => env('NAV_PASSWORD')
//                ];
//            $client = new SoapClient(env('NAV_SANDBOX_WSDL'), $options);
//
//            $params = [
//                'pCompany' => env('NAV_SANDBOX_pCompany'),
//                'pLogin'=>'audrey.huguenin',
//                'pPass' => 'Time&Space_6457'
//            ];
//
//            $result = $client->CtrlLoginCreatives($params);
//            print_r($result);
//
//        }
//            catch (Exception $e)
//            {
//                echo $e->getMessage();
//            }
//});
//
//Route::get('roles', function() {
//
//        try {
//            $options = [
//                'soap_version' => SOAP_1_1,
//                'connection_timeout' => 120,
//                'login' => env('NAV_LOGIN'),
//                'password' => env('NAV_PASSWORD')
//                ];
//            $client = new SoapClient(env('NAV_SANDBOX_WSDL'), $options);
//            $params = [
//                'pCompany' => env('NAV_SANDBOX_pCompany'),
//                'pLogin'=>'quentin.delattre',
//            ];
//
//            $result = $client->GetRoleUser($params);
//            print_r($result);
//
//        }
//            catch (Exception $e)
//            {
//                echo $e->getMessage();
//            }
//
//});
//
//Route::get('allprojects', function() {
//
//        try {
//            $options = [
//                'soap_version' => SOAP_1_1,
//                'connection_timeout' => 120,
//                'login' => env('NAV_LOGIN'),
//                'password' => env('NAV_PASSWORD')
//                ];
//            $client = new SoapClient(env('NAV_SANDBOX_WSDL_PROJECTS'), $options);
//
//
//            $result = $client->ReadMultiple();
//            $result = get_object_vars($result);
//            $result = get_object_vars($result['ReadMultiple_Result']);
//
//            print_r($result);
//
//           // $num=array_column($result['WS_JOB'], 'Job_No');
//              //  $nom=array_column($result['WS_JOB'], 'Job_Name');
//                //$fullnom=array_column($result['WS_JOB'], 'SearchField');
//                //$customer=array_column($result['WS_JOB'], 'Customer_Name');
//
//
//        }
//            catch (Exception $e)
//            {
//                echo $e->getMessage();
//            }
//
//});
//Route::get('allsubtasks', function() {
//
//        try {
//            $options = [
//                'soap_version' => SOAP_1_1,
//                'connection_timeout' => 120,
//                'login' => env('NAV_LOGIN'),
//                'password' => env('NAV_PASSWORD')
//                ];
//            $client = new SoapClient(env('NAV_SANDBOX_WSDL_SUBTASKS'), $options);
//            $params = [
//            "filter" => array
//                (
//               'Field' => '',
//                'Criteria'=>''
//                ),
//                "setSize"=>''
//            ];
//
//            $result = $client->ReadMultiple($params);
//            $result = get_object_vars($result);
//            $result = get_object_vars($result['ReadMultiple_Result']);
//           // $result = array_column($result['WS_JOBTASK'], 'Job_Task_Name');
//
////Donne tous les noms de projets qu'il y a dans l'agence
//            print_r($result['WS_JOBTASK']);
//
//
//        }
//            catch (Exception $e)
//            {
//                echo $e->getMessage();
//            }
//
//});
//
//Route::get('allusers', function() {
//
//        try {
//            $options = [
//                'soap_version' => SOAP_1_1,
//                'connection_timeout' => 120,
//                'login' => env('NAV_LOGIN'),
//                'password' => env('NAV_PASSWORD')
//                ];
//            $client = new SoapClient(env('NAV_SANDBOX_WSDL_USERS'), $options);
//            $params = [
//            "filter" => array
//                (
//               'Field' => '',
//                'Criteria'=>''
//                ),
//                "setSize"=>''
//            ];
//
//            $result = $client->ReadMultiple($params);
//            $result = get_object_vars($result);
//            $result = get_object_vars($result['ReadMultiple_Result']);
//           // $result = array_column($result['WS_JOBTASK'], 'Job_Task_Name');
//
////Donne tous les noms de projets qu'il y a dans l'agence
//            print_r($result['WS_USERS']);
//
//
//        }
//            catch (Exception $e)
//            {
//                echo $e->getMessage();
//            }
//
//});

