<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
     protected $table = 'cart_item';

    protected $primaryKey = 'id_cart_item';

    protected $fillable = [
        'id_user',
        'id_product',
        'quantity'
    ];

    public $timestamps = false;


    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }


}
