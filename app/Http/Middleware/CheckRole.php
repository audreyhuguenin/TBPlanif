<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use SoapClient;

class CheckRole
{
    /**
     * Gère une redirection en fonction du rôle de l'utilisateur qui demande cette route
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
                    return redirect("/plannings");

                case 1:
                    return redirect("/am");

                case 2:
                    return redirect("/ad");

                }
    }

/**
 * Envoie une requête à Dynamics NAV avec l'adresse mail donnée pour demander le niveau de droit de l'utilisateur auquel elle correspond.
 * Retourne la réponse de NAV: 0 pou les CREA, 1 pour les AM, 2 pour les AD
 */
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
