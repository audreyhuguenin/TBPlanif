<?php

use Illuminate\Database\Seeder;

class SubtasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
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

            $subtasksNAV=$result['WS_JOBTASK'];

             foreach($subtasksNAV as $subtaskNAV)
	        {
                   $subtaskNAV= get_object_vars($subtaskNAV);
                  
	                App\Subtask::updateOrCreate([
	                'name' => $subtaskNAV['Job_Task_Name'],
	                'project_id' =>$subtaskNAV['Job_No'] ,
		                ]);
	        }


        }
            catch (Exception $e)
            {
                echo $e->getMessage();
            }


    }
}
