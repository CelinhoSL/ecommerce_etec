<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\OrderItems;

class OrderItemController extends Controller
{
    

public function showOrderItems()
{
    
    $userId = session('user_id'); // Obtém o ID do usuário da sessão

   $orderItems = OrderItems::with(['product', 'order'])
        ->whereHas('order', function ($query) use ($userId) {
            $query->where('id_user', $userId);
        })
        ->get();

    return view('user.orders', compact('orderItems'));
}

}
