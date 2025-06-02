<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdminToken extends Model
{
    public $timestamps = false;

    protected $fillable = ['email', 'token', 'used', 'created_at', 'expires_at'];

    public static function createToken($email)
    {
        $token = Str::random(32); // Laravel helper para token aleatório
        $createdAt = now();
        $expiresAt = $createdAt->copy()->addMinutes(3);

        self::create([
            'email' => $email,
            'token' => $token,
            'created_at' => $createdAt,
            'expires_at' => $expiresAt,
        ]);

        return $token;
    }

    public static function validateToken($token)
    {
        return self::where('token', $token)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();
    }

    public static function markTokenAsUsed($token)
    {
        self::where('token', $token)->update(['used' => true]);
    }
}



