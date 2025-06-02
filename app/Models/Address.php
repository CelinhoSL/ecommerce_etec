<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    protected $table = 'address';

    // Caso sua tabela se chame 'address' (sem o 'es'), descomente a linha abaixo:
    // protected $table = 'address';

    protected $fillable = [
        'user_id',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'postal_code',
        'country',
    ];

    /**
     * Relação: Um endereço pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
