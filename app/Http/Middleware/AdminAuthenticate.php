<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o admin está logado
        if (!Session::has('admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Você precisa estar logado como administrador para acessar esta página.');
        }

        // Verifica se o ID do administrador na sessão é válido
        $adminId = Session::get('admin_id');
        $admin = Admin::find($adminId);
        
        if (!$admin) {
            Session::forget('admin_id');
            return redirect()->route('admin.login')->with('error', 'Sessão inválida. Por favor, faça login novamente.');
        }



        return $next($request);
    }
}