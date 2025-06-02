<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $table = 'user';

    protected $fillable = [
        'id_user',	'session_id',	'ip_address', 'device_info',	'first_name',	'last_name',	'birth_date',	'phone',	'email', 'password',	'created_at',	'updated_at',	'deleted_at',
    ];

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        // Hash password automatically
        $this->attributes['password'] = Hash::make($value);
    }

    public function logIpIfNotExists(): bool
    {
        $exists = DB::table('user_logs')
            ->where('user_id', $this->id)
            ->exists();

        if (!$exists) {
            DB::table('user_logs')->insert([
                'user_id' => $this->id,
                'ip_address' => $this->ip_address,
                'user_agent' => $this->device_info,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return false; // Primeira vez
        }

        return true; // Já existe log
    }

    public static function login($email, $password)
    {
        if (!Session::has('login_attempts')) {
            Session::put('login_attempts', 0);
        }

        if (Session::get('login_attempts') >= 5) {
            throw new \Exception("Muitas tentativas de login.");
        }

        $user = self::where('email', $email)->first();

        if (!$user) {
            Session::increment('login_attempts');
            throw new \Exception("Usuário não encontrado.");
        }

        if (!Hash::check($password, $user->password)) {
            Session::increment('login_attempts');
            throw new \Exception("Senha incorreta.");
        }

        Session::put('login_attempts', 0);
        return $user;
    }

    public function isNewDevice(): bool
    {
        $currentIp = request()->ip();
        $currentDevice = request()->userAgent();

        $log = DB::table('user_logs')
            ->where('user_id', $this->id)
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

    public static function phoneUsed($phone): bool
    {
        return self::where('phone', $phone)->exists();
        
    }
    

    public function orders()
    {
        return $this->hasMany(Order::class, 'id', 'id'); // Ajuste os nomes conforme o seu banco
    }

}
