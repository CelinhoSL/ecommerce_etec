@extends('user.layouts.app')
    
@vite(['resources/css/app.css', 'resources/js/app.js'])


<div class="container py-5">
    <h1 class="text-center mb-4">Produtos Comprados</h1>

    @if($orderItems->isEmpty())
        <div class="alert alert-secondary text-center">Você ainda não comprou nenhum produto.</div>
    @else
        @php $totalGeral = 0; @endphp

        @foreach($orderItems as $item)
            @php
                $subtotal = $item->quantity * $item->price;
                $totalGeral += $subtotal;
            @endphp

            <div class="d-flex align-items-center gap-3 border-bottom py-3">
                <div>
                    @if($item->product && $item->product->image)
                        <img src="{{ route('product.image', $item->product->id_product) }}" class="product-img" alt="{{ $item->product->name }}" width="80">
                    @else
                        <img src="https://via.placeholder.com/80x80?text=Imagem" alt="Sem imagem">
                    @endif
                </div>

                <div class="flex-grow-1">
                    <div><strong>{{ $item->product->name ?? 'Produto removido' }}</strong></div>
                    <div>Quantidade: {{ $item->quantity }}</div>
                    <div>Preço unitário: R$ {{ number_format($item->price, 2, ',', '.') }}</div>
                    <div>Subtotal: R$ {{ number_format($subtotal, 2, ',', '.') }}</div>
                </div>

                <div class="text-end">
                    <div><small>Pedido #{{ $item->order->id_order ?? 'N/A' }}</small></div>
                </div>
            </div>
        @endforeach

        <div class="text-end mt-4">
            <h5>Total Geral Comprado: R$ {{ number_format($totalGeral, 2, ',', '.') }}</h5>
        </div>
    @endif
</div>

