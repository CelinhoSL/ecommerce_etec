<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AdminAuthMailer;

class AdminAuthController extends Controller
{
    /**
     * Mostra o formulário de login
     */
    public function showLoginForm()
    {
        // Se já estiver logado, redireciona para o painel
        if (Session::has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.login');
    }

    /**
     * Processa o formulário de login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        try {
            $admin = Admin::login($request->username, $request->password);
            
            // Armazena o ID do admin na sessão
            Session::put('admin_id', $admin->id);
            
            // Verifica se é um novo dispositivo
            if ($admin->isNewDevice()) {
                $mailer = new AdminAuthMailer();
                $mailer->newDeviceDeteced($admin->email);
                // Ainda permitimos o login, mas notificamos o administrador
            }
            
            // Registra o IP e dispositivo atual
            $admin->logIpIfNotExists();
            
            return redirect()->route('admin.dashboard')->with('success', 'Login realizado com sucesso!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Faz logout do administrador
     */
    public function logout()
    {
        Session::forget('admin_id');
        return redirect()->route('admin.login')->with('success', 'Logout realizado com sucesso!');
    }
}