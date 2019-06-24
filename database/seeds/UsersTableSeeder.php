<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('users')->truncate();
        try {
            $options = [
                'soap_version' => SOAP_1_1,
                'connection_timeout' => 120,
                'login' => env('NAV_LOGIN'),
                'password' => env('NAV_PASSWORD')
                ];
            $client = new SoapClient(env('NAV_SANDBOX_WSDL_USERS'), $options);
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

            $usersNAV=$result['WS_USERS'];

             foreach($usersNAV as $userNAV)
                {
                $userNAV= get_object_vars($userNAV);

                App\User::firstOrCreate([
                'name' => $userNAV['Ressource_Name'],            
                ],
                ['email' => $userNAV['Ressource_Login'],
                'initials'=>$userNAV['Ressource_No']]);
                }
        }
            catch (Exception $e)
            {
                echo $e->getMessage();
            }
    
        }

}
