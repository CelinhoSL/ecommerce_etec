<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminToken;
use App\Models\AdminAuthCodeService;
use App\Http\Controllers\AdminAuthMailer;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminRegistrationController extends Controller
{
    public function register(Request $request)
    {
        // Captura o token da URL
        $token = $request->input('token');

        // Verifica se o token foi fornecido
        if (!$token) {
            return redirect()->back()->with('error_message', 'Token não fornecido.');
        }

        // Valida o token
        $tokenData = AdminToken::validateToken($token);
        if (!$tokenData) {
            return redirect()->back()->with('error_message', 'Token inválido ou expirado.');
        }

        // Verifica se o formulário foi enviado
        if ($request->isMethod('post')) {
            // Validação dos campos usando Validator
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required|min:8',
                'email'    => 'required|email',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error_message', 'Dados inválidos. Verifique os campos informados.');
            }

            // Limpeza básica dos dados
            $username = htmlspecialchars($request->input('username'));
            $password = htmlspecialchars($request->input('password'));
            $email = htmlspecialchars($request->input('email'));

            // Verifica se o nome de usuário já está em uso
            if (Admin::usernameUsed($username)) {
                return redirect()->back()->with('error_message', 'Nome de usuário já está em uso.');
            }

            // Verifica se o e-mail já está em uso
            if (Admin::emailUsed($email)) {
                return redirect()->back()->with('error_message', 'E-mail já está em uso.');
            }

            // Armazena os dados temporariamente na sessão
            Session::put('pending_admin', [
                'username' => $username,
                'password' => $password,
                'email'    => $email,
                'ip'       => $request->ip() ?? 'unknown',
                'device'   => $request->userAgent() ?? 'unknown',
            ]);

            // Gera e salva o código
            $code = AdminAuthCodeService::generateCode();
            AdminAuthCodeService::saveCode($email, $code);

            // Envia o código por e-mail
            $mailer = new AdminAuthMailer();
            $mailer->sendCodeResetPassword($email, $code);

            return redirect()->route('admin.confirm.code', ['token' => $token]);
        }
        
        return view('admin_register', ['token' => $token]);
    }
}
