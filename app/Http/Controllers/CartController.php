<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $userId = session('user_id'); 

        // Verifica se o produto já está no carrinho do usuário
        $item = Cart::where('id_user', $userId)
                        ->where('id_product', $productId)
                        ->first();

        if ($item) {
            // Se já existir, incrementa a quantidade
            $item->quantity += 1;
            $item->save();
        } else {
            // Se não existir, cria um novo item
            Cart::create([
                'id_user' => $userId,
                'id_product' => $productId,
                'quantity' => 1
            ]);
        }
        session(['cart_count' => session('cart_count', 0) + 1]);

        return redirect()->back()->with('success', 'Uma unidade do produto foi adicionada ao carrinho!');
    }


    public function index()
{
    $userId = session('user_id');

    $cartItems = Cart::where('id_user', $userId)
        ->with('product') // relacionamento com o produto
        ->get();

    return view('user.cart', compact('cartItems'));
}

public function remove($id)
{
    $item = Cart::findOrFail($id);
    $item->delete();

    return redirect()->route('user.cart')->with('success', 'Item removido com sucesso.');
}



}
