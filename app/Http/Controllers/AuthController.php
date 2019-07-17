<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use SoapClient;
use App\User;

class AuthController extends Controller
{
    /* Renvoie sur la vue du formulaire pour se loguer
    *
    */
   public function form()
   {
       return view('login');
   }

   /*Permet de faire l'authentification. Cette fonction se connect à Dynamics NAV, envoie le mais et password rentrés par l'utilisateurs. 
   Selon la réponse, connecte ou non l'utilisateurs à son profil.
   * 
   */
   
   public function check(Request $request)
   {
       $email = $request->input('email', '');
       $password = $request->input('password', '');
       

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
                'pLogin'=>$email,
                'pPass' => $password
            ];

            $result = $client->CtrlLoginCreatives($params);
            $result= get_object_vars($result);


            switch ($result['return_value'])
            {
                case -1:
                    echo "Login incorrect";
                    return response()->redirectToAction('AuthController@form')->with('error', true);
                    break;
                case -2:
                    echo "mot de passe incorrect";
                    return response()->redirectToAction('AuthController@form')->with('error', true);
                    break;
                default:
                    $user = User::where('email', $email)->first();
                    Auth::login($user, true);
                    $intented = session('url_intended');
                    return response()->redirectTo($intented ?? '/');
                }

        }
            catch (Exception $e)
            {
                echo $e->getMessage();
            }
   }
   
   /*
   * Log out de l'application, déconnecte l'utilisateur
   */
   public function logout()
   {
       Auth::logout();
       return response()->redirectToAction('AuthController@form');
   }

   
}