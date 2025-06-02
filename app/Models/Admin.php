<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Admin extends Authenticatable
{
    protected $table = 'admin';

    protected $fillable = [
        'username', 'password', 'email', 'ip_address', 'device_info'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Override the username field for authentication
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function setPasswordAttribute($value)
    {
        // Hash password automatically
        $this->attributes['password'] = Hash::make($value);
    }

    public function logIpIfNotExists(): bool
    {
        $exists = DB::table('admin_log')
            ->where('admin_id', $this->id)
            ->exists();

        if (!$exists) {
            DB::table('admin_log')->insert([
                'admin_id' => $this->id,
                'ip_address' => $this->ip_address,
                'user_agent' => $this->device_info,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return false; // Primeira vez
        }

        return true; // Já existe log
    }

    public static function login($username, $password)
    {
        if (!Session::has('login_attempts')) {
            Session::put('login_attempts', 0);
        }

        if (Session::get('login_attempts') >= 5) {
            throw new \Exception("Muitas tentativas de login.");
        }

        $admin = self::where('username', $username)->first();

        if (!$admin) {
            Session::increment('login_attempts');
            throw new \Exception("Usuário não encontrado.");
        }

        if (!Hash::check($password, $admin->password)) {
            Session::increment('login_attempts');
            throw new \Exception("Senha incorreta.");
        }

        Session::put('login_attempts', 0);
        return $admin;
    }

    public function isNewDevice(): bool
    {
        $currentIp = request()->ip();
        $currentDevice = request()->userAgent();

        $log = DB::table('admin_log')
            ->where('admin_id', $this->id)
            ->first();

        if ($log) {
            return $log->ip_address !== $currentIp || $log->user_agent !== $currentDevice;
        }

        return false;
    }

    public static function emailUsed($email): bool
    {
        return self::where('email', $email)->exists();
    }

    public static function usernameUsed($username): bool
    {
        return self::where('username', $username)->exists();
    }
}