<!-- Navbar para telas pequenas -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-lg-none">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" id="sidebarToggle">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="{{ route('home') }}">Minha Loja</a>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="p-3 border-bottom border-secondary">
        <h5 class="text-white mb-0">Minha Loja</h5>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
            <i class="fas fa-home"></i>Home
        </a>
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
            <i class="fas fa-user"></i>Conta
        </a>
        <a class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}" href="{{ route('user.cart') }}">
            <i class="fas fa-shopping-cart"></i>Carrinho
            @if(session('cart_count', 0) > 0)
            <span class="badge bg-primary ms-2">{{ session('cart_count') }}</span>
            @endif
        </a>
        <a class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}" href="{{ route('user.order.items') }}">
            <i class="fas fa-box"></i>Compras
        </a>
        <hr class="border-secondary">
        @if(session('user_id'))
            <a class="nav-link" href="{{ route('user.logout') }}">
                <i class="fas fa-sign-out-alt"></i>Logout
            </a>
        @else
            <a class="nav-link" href="{{ route('user.login') }}">
                <i class="fas fa-sign-in-alt"></i>Login
            </a>
        @endif
    </nav>
</div>

<!-- Overlay para fechar sidebar em telas pequenas -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>