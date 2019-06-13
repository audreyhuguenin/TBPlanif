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
    return view('base');
});

Route::resource('users', 'UserController');
Route::resource('tasks', 'TaskController');
Route::resource('subtasks', 'SubtaskController');
Route::resource('projects', 'ProjectController');
Route::resource('plannings', 'PlanningController');
Route::resource('assignations', 'AssignationController');

Route::get('syncprojects', function () {
$syncprojects= new ProjectsTableSeeder();
$syncprojects->run();
$syncsubtasks= new SubtasksTableSeeder();
$syncsubtasks->run();
    return 'synchronized';
});

Route::get('navlogin', function() {

    
        try {
            $options = [ 
                'soap_version' => SOAP_1_1,
                'connection_timeout' => 120,
                'login' => env('NAV_LOGIN'),
                'password' => env('NAV_PASSWORD')
                ];
            $client = new SoapClient(env('NAV_SANDBOX_WSDL'), $options);
            $params = [
                'pCompany' => env('NAV_SANDBOX_pCompany'),
                'pLogin'=>'audrey.huguenin',
                'pPass' => 'Time&Space_6457'
            ];

            $result = $client->CtrlLoginCreatives($params);
            print_r($result);
            
        }
            catch (Exception $e)
            {
                echo $e->getMessage();
            }
});

Route::get('roles', function() {

        try {
            $options = [
                'soap_version' => SOAP_1_1,
                'connection_timeout' => 120,
                'login' => env('NAV_LOGIN'),
                'password' => env('NAV_PASSWORD')
                ];
            $client = new SoapClient(env('NAV_SANDBOX_WSDL'), $options);
            $params = [
                'pCompany' => env('NAV_SANDBOX_pCompany'),
                'pLogin'=>'quentin.delattre',
            ];

            $result = $client->GetRoleUser($params);
            print_r($result);

        }
            catch (Exception $e)
            {
                echo $e->getMessage();
            }

});

Route::get('allprojects', function() {

        try {
            $options = [
                'soap_version' => SOAP_1_1,
                'connection_timeout' => 120,
                'login' => env('NAV_LOGIN'),
                'password' => env('NAV_PASSWORD')
                ];
            $client = new SoapClient(env('NAV_SANDBOX_WSDL_PROJECTS'), $options);


            $result = $client->ReadMultiple();
            $result = get_object_vars($result);
            $result = get_object_vars($result['ReadMultiple_Result']);

            print_r($result);

           // $num=array_column($result['WS_JOB'], 'Job_No');
              //  $nom=array_column($result['WS_JOB'], 'Job_Name');
                //$fullnom=array_column($result['WS_JOB'], 'SearchField');
                //$customer=array_column($result['WS_JOB'], 'Customer_Name');


        }
            catch (Exception $e)
            {
                echo $e->getMessage();
            }

});
Route::get('allsubtasks', function() {

        try {
            $options = [
                'soap_version' => SOAP_1_1,
                'connection_timeout' => 120,
                'login' => env('NAV_LOGIN'),
                'password' => env('NAV_PASSWORD')
                ];
            $client = new SoapClient(env('NAV_SANDBOX_WSDL_SUBTASKS'), $options);
            $params = [
            "filter" => array
                (
               'Field' => '',
                'Criteria'=>''
                ),
                "setSize"=>''
            ];

            $result = $client->ReadMultiple($params);
            $result = get_object_vars($result);
            $result = get_object_vars($result['ReadMultiple_Result']);
           // $result = array_column($result['WS_JOBTASK'], 'Job_Task_Name');
           
//Donne tous les noms de projets qu'il y a dans l'agence
            print_r($result['WS_JOBTASK']);
    

        }
            catch (Exception $e)
            {
                echo $e->getMessage();
            }

});




