<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use SoapClient;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //exit(Auth::user()->email);

        $role=$this->privilege(Auth::user()->email);
        switch ($role)
            {
                case 0:
                    return redirect("/planif");

                case 1:
                    return redirect("/am");

                case 2:
                    return redirect("/ad");

                }
    }


    public function privilege($userLogin)
   {
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
                'pLogin'=>$userLogin,
            ];

            $result = $client->GetRoleUser($params);
            $result= get_object_vars($result);
            return $result['return_value'];

        }
            catch (Exception $e)
            {
                echo $e->getMessage();
            }
   }
}
