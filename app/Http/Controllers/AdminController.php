<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\GenericUser;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function adminFirstAcess()
     {
         $email = "lopesmarcelotadeu@gmail.com";
         $token = AdminToken::createToken($email);
         $url = route('admin.register.data', ['token' => $token]);
         $emailService = new AdminEmailService();
        $emailService->sendTokenEmail($email, $url);
     
        

     }
     

    public function index()
    {
       

    }

    public function login(Request $request)
{
    $data = $request->validate([
        'username' => 'required',
        'password' => 'required|min:8',
    ]);

    $admin = DB::table('admin')
        ->where('username', $data['username'])
        ->first();

    if ($admin && Hash::check($data['password'], $admin->password)) {
        $adminUser = new GenericUser((array) $admin);

        Auth::guard('admin')->login($adminUser);

        $request->session()->regenerate();

        // Armazenando com a facade Session (com "S")
        Session::put('admin_id', $admin->id);

       return redirect()->route('admin.dashboard');


    }

    return back()->withErrors([
        'username' => 'Credenciais inválidas.',
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('AuthAdmin');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // Desloga o admin
        Auth::guard('admin')->logout();

        // Limpa a sessão do admin
        $request->session()->invalidate();

        // Regenera o token da sessão
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
