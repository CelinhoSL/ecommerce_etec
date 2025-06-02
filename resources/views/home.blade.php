<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja TCC</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    @vite(['resources/js/app.js', 'resources/css/app.css', 'resources/css/home.css', 'resources/css/card.css'])
</head>

<body>

    <div class="banner">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <img src="{{ asset('img/logo_loja.png') }}" alt="logo da loja" width="125px">
                </div>

                <nav>
                    <ul id="menu-items">
                        <li><a href="#" title="">Início</a></li>
                        <li><a href="#product" title="">Produtos</a></li>
                        <li><a href="#about" title="">Empresa</a></li>
                        <li><a href="#footer" title="">Contatos</a></li>
                        <li><a href="{{ route('user.dashboard') }}" title="">Minha Conta</a></li>
                    </ul>
                </nav>

                <img src="{{ asset('img/sacola.png') }}" alt="carrinho" width="30px" height="30px">
                <img src="{{ asset('img/menu.png') }}" alt="" class="mobile-menu" onclick="mobileMenu()">
            </div>
        </div>

        <div class="row">
            <div class="col-2">
                <h1>Conheça nossos produtos! <br> lorem ipsum sit amet</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, repellendus.</p>
                <br><a href="#" class="btn">Mais Informações &#8594;</a>
            </div>

            <div class="col-2">
                <img src="{{ asset('img/banner1.png') }}" alt="">
            </div>
        </div>
    </div>

    <div class="categories-body">

        <div class="row">
            <div class="col-3"></div>
        </div>

        <div class="categories" id="product">
            <div class="categories-body">
                <h2 class="title">Produtos em Destaque</h2>

                @include('product.index')

            </div> <!-- end .categories-body -->
        </div> <!-- end .categories -->

    </div> <!-- end general .categories-body -->


    <section class="about-section" id="about">
    <div class="container">
        <h2 class="about-title">Sobre a Loja</h2>
        <div class="about-content">
            <div class="about-text">
                <p>
                    A <strong>Loja TCC</strong> foi criada com o objetivo de oferecer produtos de qualidade e um atendimento humanizado, sempre focando em praticidade, confiança e inovação. 
                    Nosso catálogo é cuidadosamente selecionado para garantir que cada item entregue ao cliente tenha valor, estilo e funcionalidade.
                </p>
                <p>
                    Valorizamos cada cliente e acreditamos que a tecnologia pode aproximar pessoas e transformar experiências de compra. Seja bem-vindo(a) à nossa loja, onde cada detalhe importa.
                </p>
            </div>
            <div class="about-image">
                <img src="{{ asset('img/foto1.jpg') }}" alt="Imagem sobre a loja">
            </div>
        </div>
    </div>
</section>



    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <h3>Baixe nosso app</h3>
                    <p>Baixe somente em plataformas oficiais!</p>
                    <div class="app-logo">
                        <img src="{{ asset('img/google.jpg') }}" alt="">
                        <img src="{{ asset('img/apple.jpg') }}" alt="">
                    </div>
                </div>

                <div class="footer-col-2" id="footer">
                    <ul>
                        <li>Nossa história</li>
                        <li>Contatos</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Ionicons again (no need to duplicate but you can keep it) -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>
