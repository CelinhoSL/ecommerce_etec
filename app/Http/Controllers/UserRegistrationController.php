<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserAuthCodeService;
use Illuminate\Support\Facades\Session;
use App\Mail\UserAuthMailer;

class UserRegistrationController extends Controller
{
    public function register(Request $request){

        if($request->isMethod('post')){

            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*_])[A-Za-z\d!@#$%^&*_]+$/',
                'email'    => 'required|email',
                'first_name' => 'required',
                'last_name' => 'required',
                'birth_date' => 'required|date',
'phone' => [
    'required',
    'regex:/^(\(\d{2}\)\s\d{5,6}-\d{4}|\d{2}\s\d{5,6}-\d{4}|\d{10,11}|\d{1,2}\s\d{1,3}\s\d{4,5}-\d{4})$/'
],

            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error_message', 'Dados inválidos. Verifique os campos informados.');
            }

            // Limpeza básica dos dados
            $first_name = htmlspecialchars($request->input('first_name'));
            $last_name = htmlspecialchars($request->input('last_name'));
            $birth_date = htmlspecialchars($request->input('birth_date'));
            $phone = htmlspecialchars($request->input('phone'));
            $email = htmlspecialchars($request->input('email'));
            $password = htmlspecialchars($request->input('password'));
            
        }

        if(User::emailUsed($email)){
            return redirect()->back()->with('error_message', 'E-mail já está em uso.');
        }

        if(User::phoneUsed($phone)){
            return redirect()->back()->with('error_message', 'Telefone já está em uso.');
        }
        
       Session::put('user_registration', [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'birth_date' => $birth_date,
            'phone' => $phone,
            'email' => $email,
            'password' => $password,
            'ip' => $request->ip(), // Agora o IP será salvo corretamente
            'device' => $request->userAgent(), // Usa o método correto para obter o User-Agent
        ]);
        $code = UserAuthCodeService::generateCode();
        UserAuthCodeService::saveCode($email, $code);

        $mailer = new UserMailer();
        $mailer->sendCode($email, $code);
        $user = new User();
        return redirect()->route('user.register.confirmation')->with('email', $email);

 


    }
}
