<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Minha Loja')</title>
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/sidebar.css', 'resources/js/sidebar.js'])
    
    <!-- Sidebar Styles -->
    
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="bg-light">
    <!-- Include Sidebar -->
    @include('user.components.sidebar')

    <!-- Conteúdo Principal -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Sidebar JavaScript -->
    
    
    @stack('scripts')
</body>
</html>