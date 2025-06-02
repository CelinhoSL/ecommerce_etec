@extends('user.layouts.app')

@section('title', 'Dashboard - Minha Conta')

@push('styles')
<style>
    .dashboard-card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: transform 0.2s ease;
    }
    
    .dashboard-card:hover {
        transform: translateY(-2px);
    }
    
    .user-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #007bff, #6610f2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        font-weight: bold;
    }
    
    .quick-action {
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .quick-action:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-2">Minha Conta</h1>
            <p class="text-muted">Gerencie suas informações e configurações</p>
        </div>
    </div>

    <!-- Informações do Usuário -->
    <div class="row mb-4">
        <div class="col-lg-12 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="user-avatar">
                                {{-- Primeira letra do nome do usuário --}}
                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                            </div>
                        </div>
                        <div class="col">
                            <h5 class="mb-1">{{ $user->name ?? 'Nome do Usuário' }}</h5>
                            <p class="text-muted mb-1">{{ $user->email ?? 'email@exemplo.com' }}</p>
                            <small class="text-muted">
                                Membro desde {{ isset($user->created_at) ? $user->created_at->format('M Y') : 'Jan 2024' }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

    <!-- Ações Rápidas -->
    <div class="row">
        <div class="col-12 mb-3">
            <h5>Configurações da Conta</h5>
        </div>
        
       

        <div class="col-lg-6 col-md-6 mb-3">
            <a href="{{route('user.show.address') }}" class="quick-action">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center">
                        <div class="text-success mb-3">
                            <i class="fas fa-map-marker-alt fa-2x"></i>
                        </div>
                        <h6 class="card-title">Endereços</h6>
                        <p class="card-text text-muted small">Gerenciar endereços de entrega</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-6 col-md-6 mb-3">
            <a href="{{ route('user.order.items') }}" class="quick-action">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center">
                        <div class="text-info mb-3">
                            <i class="fas fa-history fa-2x"></i>
                        </div>
                        <h6 class="card-title">Meus Pedidos</h6>
                        <p class="card-text text-muted small">Ver histórico e status dos pedidos</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

@vite(['resources/js/app.js, resources/js/bootstrap.js'])
@endsection