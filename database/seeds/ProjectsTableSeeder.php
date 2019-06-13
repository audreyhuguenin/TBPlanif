<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
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
            $client = new SoapClient(env('NAV_SANDBOX_WSDL_PROJECTS'), $options);


            $result = $client->ReadMultiple();
            $result = get_object_vars($result);
            $result = get_object_vars($result['ReadMultiple_Result']);

                $projectsNAV=$result['WS_JOB'];


                foreach($projectsNAV as $projectNAV)
	{
                   $projectNAV= get_object_vars($projectNAV);
	App\Project::updateOrCreate([
	'name' => $projectNAV['Job_Name'],
                'number' => $projectNAV['Job_No'],
            'fullName'=>$projectNAV['SearchField'],
            'customer'=>$projectNAV['Customer_Name'],
		]);
	}

        }
            catch (Exception $e)
            {
                echo $e->getMessage();
            }

    
    }
}
