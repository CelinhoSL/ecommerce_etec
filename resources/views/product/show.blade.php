<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/product.css', 'resources/js/product.js'])

    <!-- Fonte minimalista -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
       
    </style>
</head>
<body>

   

    <!-- Partículas sutis -->
    <div class="bg-particles" id="particles"></div>

    <div class="main-container">
        <a href="{{ route('home')}}" class="back-link">
            ← Voltar aos Produtos
        </a>

     @if(session('success'))
    <div class="alert alert-success" style="margin: 20px;">
        {{ session('success') }}
    </div>
@endif

        <div class="product-card">
            <div class="availability-badge">
                Em Estoque
            </div>

            <div class="product-layout">
                <div class="image-section">
                    <div class="image-container">
                        @if($product->image)
                            <img src="{{ route('product.image', $product->id_product) }}" alt="{{ $product->name }}" class="product-image">
                        @else
                            <img src="https://via.placeholder.com/600x400?text=Sem+Imagem&color=4a5568&bg=f7fafc" alt="Sem imagem" class="product-image">
                        @endif
                    </div>
                </div>

                <div class="details-section">
                    <div class="product-header">
                        <h1 class="product-title">{{ $product->name }}</h1>
                        <p class="product-description">{{ $product->description }}</p>
                    </div>

                    <div class="specs-container">
                        <h3 class="specs-title">Especificações</h3>
                        <div class="specs-grid">
                            <div class="spec-item">
                                <span class="spec-label">Quantidade</span>
                                <span class="spec-value">{{ $product->quantity }}</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">Tamanho</span>
                                <span class="spec-value">{{ $product->size }}</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">Cor</span>
                                <span class="spec-value">{{ $product->color }}</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">Dimensões</span>
                                <span class="spec-value">{{ $product->height }} × {{ $product->width }}</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">Peso</span>
                                <span class="spec-value">{{ $product->weight }}</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">Categoria</span>
                                <span class="spec-value">{{ $product->category }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="purchase-section">
                        <div class="price-container">
                            <div class="price-label">Preço</div>
                            <div class="price-value">R$ {{ number_format($product->price, 2, ',', '.') }}</div>
                        </div>

                        <div class="actions-section">
                            <form action="{{ route('user.cart.add', $product->id_product) }}" method="POST" style="flex: 1;">
                                 @csrf
                                
                                <input type="hidden" name="product_id" value="{{ $product->id_product }}">
                                <button type="submit" class="btn btn-cart">Adicionar ao Carrinho</button>
                            </form>

                            <form action="{{ route('user.buy.now') }}" method="POST" style="flex: 1;">
    @csrf
    {{-- Adiciona um campo oculto para enviar o ID do produto --}}
    <input type="hidden" name="id_product" value="{{ $product->id_product }}">

    {{-- Se precisar enviar a quantidade, adicione um campo para ela também --}}
    {{-- <input type="hidden" name="quantity" value="1"> --}}

    <button type="submit" class="btn btn-buy">Comprar Agora</button>
</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>