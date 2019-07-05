<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use SoapClient;
use App\User;

class AuthController extends Controller
{
   public function form()
   {
       return view('login');
   }
   
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
   
   public function logout()
   {
       Auth::logout();
       return response()->redirectToAction('AuthController@form');
   }

   
}