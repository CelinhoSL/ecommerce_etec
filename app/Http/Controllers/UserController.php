<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\GenericUser;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = session('user_id');

        $user = \App\Models\User::select('id', 'first_name', 'last_name', 'email', 'created_at')
            ->find($userId);

        $userData = (object)[
            'name' => $user ? $user->first_name . ' ' . $user->last_name : '',
            'email' => $user->email ?? '',
            'created_at' => $user->created_at ?? null,
        ];

        return view('user.Dashboard', [
            'user' => $userData,
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = \App\Models\User::where('email', $data['email'])->first();

        if ($user && \Hash::check($data['password'], $user->password)) {
            \Auth::login($user);

            $request->session()->regenerate();
            \Session::put('user_id', $user->id);

            return redirect()->route('user.dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);
    }

    public function buyProduct(Request $request)
    {
        $product = Product::findOrFail($request->id_product);
        $quantity = $request->input('quantity', 1);
        $total = $product->price * $quantity;

        // ✅ CRIAR PEDIDO SEM PIX_CODE (SERÁ GERADO NO CHECKOUT)
        $order = Order::create([
            'id_user' => session('user_id'),
            'total_amount' => $total,
            'status' => 'pending',
            'payment_method' => 'pix',
            'order_code' => strtoupper(uniqid('ORD')),
            'pix_key' => 'chavepix@example.com', // ✅ SUBSTITUA PELA CHAVE PIX REAL
            'pix_code' => null, // ✅ SERÁ GERADO NO CHECKOUT
            'expires_at' => now()->addMinutes(30),
        ]);

        OrderItem::create([
            'id_order' => $order->id_order,
            'id_product' => $product->id_product,
            'quantity' => $quantity,
            'price' => $product->price,
        ]);

        return redirect()->route('user.checkout', ['orderId' => $order->id_order]);
    }

    public function buyCart()
    {
        $userId = session('user_id');
        $cartItems = Cart::where('id_user', $userId)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Seu carrinho está vazio.');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // ✅ CRIAR PEDIDO SEM PIX_CODE (SERÁ GERADO NO CHECKOUT)
        $order = Order::create([
            'id_user' => $userId,
            'total_amount' => $total,
            'status' => 'pending',
            'payment_method' => 'pix',
            'order_code' => strtoupper(uniqid('ORD')),
            'pix_key' => 'chavepix@example.com', // ✅ SUBSTITUA PELA CHAVE PIX REAL
            'pix_code' => null, // ✅ SERÁ GERADO NO CHECKOUT
            'expires_at' => now()->addMinutes(30),
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'id_order' => $order->id_order,
                'id_product' => $item->product->id_product,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        Cart::where('id_user', $userId)->delete();

        return redirect()->route('user.checkout.cart.get', ['orderId' => $order->id_order]);
    }

    public function checkout($orderId)
    {
        $order = \App\Models\Order::with('orderItems.product')->findOrFail($orderId);
        
        return view('user/checkout', compact('order'));
    }

    public function card()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        \Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}