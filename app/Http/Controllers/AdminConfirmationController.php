<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminToken;
use App\Models\AdminAuthCodeService;
use App\Http\Controllers\AdminAuthMailer;
use Illuminate\Support\Facades\Session;

class AdminConfirmationController extends Controller
{
    public function ConfirmCode(Request $request)
    {
        // Verifica se o código foi enviado
        $code = $request->input('code');
        if (!$code) {
            return redirect()->back()->with('error', 'Digite apenas números.');
        }

        // Verifica se os dados do administrador pendente estão na sessão
        if (!Session::has('pending_admin')) {
            return redirect()->route('admin.register')->with('error', 'Dados do cadastro não encontrados. Refaça o processo.');
        }

        $data = Session::get('pending_admin');
        $email = $data['email'];

        // Verifica o código de autenticação
        if (AdminAuthCodeService::verifyCode($email, $code)) {
            // Cria o administrador
            $admin = new Admin();
            $admin->username = $data['username'];
            $admin->password = $data['password']; // Será automaticamente hashado pelo mutator no modelo
            $admin->email = $data['email'];
            $admin->ip_address = $data['ip'];
            $admin->device_info = $data['device'];
            $admin->save();

            // Loga o IP e verifica se é um novo dispositivo
            $admin->logIpIfNotExists();
            if ($admin->isNewDevice()) {
                $mailer = new AdminAuthMailer();
                $mailer->newDeviceDeteced($email);
            }

            // Marca o token como usado
            $token = $request->query('token');
            AdminToken::markTokenAsUsed($token);

            // Limpa os dados da sessão
            
            Session::put('admin_id', $admin->id);

            return redirect()->route('admin.dashboard')->with('success', 'Cadastro concluído!');
        } else {
            return redirect()->back()->with('error', 'Código inválido ou expirado.');
        }
    }
}