<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use App\Http\Kernel;
use App\Http\Middleware\AdminAuthenticate;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $adminId = Session::get('admin_id');
        $admin = Admin::find($adminId);
        
        return view('admin/dashboard', ['admin' => $admin]); // sem pasta 'admin'
    }
    
    public function settings()
    {
        $adminId = Session::get('admin_id');
        $admin = Admin::find($adminId);
        
        return view('settings', ['admin' => $admin]); // sem pasta 'admin'
    }

    
}
