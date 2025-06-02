<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class UserAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('user_id')) {
            return redirect()->route('user.login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        $userId = Session::get('user_id');
        $user = User::find($userId);

        if (!$user) {
            Session::forget('user_id');
            return redirect()->route('user.login')->with('error', 'Sessão inválida. Por favor, faça login novamente.');
        }

        // If authentication passes, continue to the next middleware/request
        return $next($request);
    }
}
