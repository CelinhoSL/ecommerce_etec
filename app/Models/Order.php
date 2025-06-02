<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    
    protected $fillable = [
        'id_user',
        'total_amount',
        'status',
        'payment_method',
        'order_code',
        'pix_key',
        'expires_at'
    ];
    
    protected $casts = [
        'expires_at' => 'datetime',
        'total_amount' => 'decimal:2'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'id_order', 'id_order');
    }
    
    public function isExpired()
    {
        return $this->expires_at < now();
    }
    
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Pendente</span>',
            'paid' => '<span class="badge bg-success">Pago</span>',
            'expired' => '<span class="badge bg-danger">Expirado</span>',
            'cancelled' => '<span class="badge bg-secondary">Cancelado</span>',
        ];
        
        return $badges[$this->status] ?? '<span class="badge bg-dark">Desconhecido</span>';
    }
}

// app/Models/OrderItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id_order_item';
    
    protected $fillable = [
        'id_order',
        'id_user',
        'id_product',
        'quantity',
        'price'
    ];
    
    protected $casts = [
        'price' => 'decimal:2'
    ];
    
    public $timestamps = false;
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }

  // App\Models\Order.php

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'id_order');
    }


}