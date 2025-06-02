
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/card.css'])
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* Para que o link ocupe todo o card e remova sublinhado e cor azul padrão */
        a.product-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        a.product-link:hover {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
    <div class="container mt-4">
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-4 mb-4 d-flex align-items-stretch">
                <a href="{{ route('product.show', $product->id_product) }}" class="product-link w-100">
                    <div class="card w-100">
                        @if($product->image)
                            <img src="{{ route('product.image', $product->id_product) }}" class="card-img-top" alt="{{ $product->name }}">
                        @else
                            <img src="https://via.placeholder.com/300x240?text=Sem+Imagem" class="card-img-top" alt="Sem imagem">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <ul class="list-group list-group-flush mt-2">
                                <li class="list-group-item">Preço: R$ {{ number_format($product->price, 2, ',', '.') }}</li>
                                <li class="list-group-item">Quantidade: {{ $product->quantity }}</li>
                                <li class="list-group-item">Tamanho: {{ $product->size }} | Cor: {{ $product->color }}</li>
                                <li class="list-group-item">Dimensões: {{ $product->height }} x {{ $product->width }}</li>
                                <li class="list-group-item">Peso: {{ $product->weight }}</li>
                                <li class="list-group-item">Categoria: {{ $product->category }}</li>
                            </ul>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>

