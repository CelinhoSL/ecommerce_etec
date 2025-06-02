<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserAuthCodeService extends Model
{
    public static function generateCode(): string
    {
        return strval(rand(100000, 999999));
    }

    // Salva o código no banco de dados com validade de 10 minutos
    public static function saveCode(string $email, string $code): void
    {
        DB::table('user_registration_code')->insert([
            'email' => $email,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(3),
        ]);
    }

    // Verifica se o código ainda é válido
    public static function verifyCode(string $email, string $code): bool
    {
        return DB::table('user_registration_code')
            ->where('email', $email)
            ->where('code', $code)
            ->where('expires_at', '>', Carbon::now())
            ->exists();
    }

    // Gera um novo token (string aleatória) e atualiza o registro
    public static function generateNewToken(string $email): string
    {
        $newToken = Str::random(32);

        DB::table('user_registration_code')
            ->where('email', $email)
            ->update([
                'code' => $newToken,
                'expires_at' => Carbon::now()->addMinutes(3),
            ]);

        return $newToken;
    }
}

