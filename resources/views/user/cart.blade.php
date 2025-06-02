@extends('user.layouts.app')

@section('title', 'Carrinho - Minha Conta')

@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/cart.css'])

    


@section('content')




<div class="container py-5 cart-wrapper">
    <h1 class="cart-title text-center"> Seu Carrinho</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if($cartItems->isEmpty())
        <div class="alert alert-secondary text-center">
            O carrinho está vazio. Que tal adicionar algo bonito?
        </div>
    @else
        @php $total = 0; @endphp

        @foreach($cartItems as $item)
            @php
                $subtotal = $item->quantity * $item->product->price;
                $total += $subtotal;
            @endphp

            <div class="cart-card d-flex align-items-center gap-3">
                <div>
                    @if($item->product->image)
                        <img src="{{ route('product.image', $item->product->id_product) }}" class="product-img" alt="{{ $item->product->name }}">
                    @else
                        <img src="https://via.placeholder.com/100x100?text=Imagem" class="product-img" alt="Sem imagem">
                    @endif
                </div>

                <div class="flex-grow-1">
                    <div class="product-name">{{ $item->product->name }}</div>
                    <div class="product-price">Preço unitário: R$ {{ number_format($item->product->price, 2, ',', '.') }}</div>
                    <div class="product-price">Quantidade: {{ $item->quantity }}</div>
                </div>

                <div class="text-end">
                    <div class="product-subtotal">Subtotal:</div>
                    <div class="text-success fw-semibold">R$ {{ number_format($subtotal, 2, ',', '.') }}</div>

                    <form action="{{ route('cart.remove', $item->id_cart_item) }}" method="POST" onsubmit="return confirm('Deseja remover este item do carrinho?')" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-remove" title="Remover item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5V2h2.5a.5.5 0 0 1 0 1h-.538l-.4 10.607a1.5 1.5 0 0 1-1.493 1.393H5.43a1.5 1.5 0 0 1-1.493-1.393L3.538 3H3a.5.5 0 0 1 0-1H5.5v-.5a.5.5 0 0 1 .5-.5zm3.5 1v-.5h-3V2h3zM4.538 3l.39 10.393a.5.5 0 0 0 .497.482h5.134a.5.5 0 0 0 .497-.482L11.462 3H4.538z"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

        <div class="total-section mt-4 d-flex justify-content-between align-items-center">
            <h4>Total: R$ {{ number_format($total, 2, ',', '.') }}</h4>
            <form action="{{ route('user.checkout.cart.post') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success btn-checkout">Finalizar Compra</button>
            </form>
        </div>
    @endif
</div>

@vite(['resources/js/bootstrap.js'])

@endsection