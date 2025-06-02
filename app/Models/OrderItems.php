<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $table = 'order_items'; // Nome da tabela

    protected $primaryKey = 'id_order_item'; // Chave primária personalizada

    public $timestamps = false; // Se sua tabela não tem `created_at`/`updated_at`

    protected $fillable = [
        'id_order',
        'id_product',
        'quantity',
        'price',
    ];

    // Relacionamento com produto
    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
