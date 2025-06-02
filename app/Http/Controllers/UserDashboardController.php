<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Http\Middleware\UserAuthenticate;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = Session::get('user_id');
        $user = User::find($userId);
        
        return view('user/userDashboard', ['user' => $user]); // sem pasta 'user'
    }
    
    public function settings()
    {
        $userId = Session::get('user_id');
        $user = User::find($userId);
        
        return view('settings', ['user' => $user]); // sem pasta 'admin'
    }

}