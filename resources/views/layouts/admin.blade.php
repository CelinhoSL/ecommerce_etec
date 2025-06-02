<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel Administrativo')</title>
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/css/adminDashboard.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row flex-nowrap">
            {{-- Sidebar --}}
            <x-admin.sidebar />
            
            {{-- Conteúdo principal --}}
            <div class="col py-4">
                @yield('content')
            </div>
        </div>
    </div>
    
    {{-- Scripts --}}
    @vite('resources/js/admin.js')
    @stack('scripts')
</body>
</html>