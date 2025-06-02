<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Http\Controllers\UserMailer;
use App\Models\UserAuthCodeService;


class UserConfirmationController extends Controller
{
    public function confirmCode(Request $request){

        $code = $request->input(htmlspecialchars('code'));
        if (!$code) {
            return redirect()->back()->with('error', 'Digite apenas números.');
        }

        if(!Session::has('user_registration')){
            return redirect()->back()->with("error, Dados do cadastro não encontrados. Refaça o processo.");
        }

        $data = Session::get('user_registration');
        $email = $data['email'];

        if (!$email) {
            return redirect()->back()->with('error', 'Email não fornecido.');
        }

        if(UserAuthCodeService::verifyCode($email, $code)){

            $user = new User();
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->birth_date = $data['birth_date'];
            $user->phone = $data['phone'];
            $user->email = $data['email'];
            $user->password = $data['password']; // Será automaticamente hashado pelo mutator no modelo
            $user->ip_address = $data['ip'];
            $user->device_info = $data['device'];
            $user->save();
            // Loga o IP e verifica se é um novo dispositivo
            $user->logIpIfNotExists();
            if ($user->isNewDevice()) {
                $mailer = new UserMailer();
                $mailer->newDeviceDeteced($email);
            }
            // Limpa os dados da sessão
            Session::put('user_id', $user->id);
            return redirect()->route('user.dashboard')->with('success', 'Cadastro concluído!');
        }
        else {
            return redirect()->back()->with('error', 'Código inválido ou expirado.');
        }

    }
}
