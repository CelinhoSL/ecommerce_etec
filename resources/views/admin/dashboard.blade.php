<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/adminDashboard.css'])
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Sidebar -->
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 sidebar">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-3 text-white min-vh-100">
                    <div class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <i class="fas fa-shield-alt fs-4 me-2"></i>
                        <span class="fs-5 d-none d-sm-inline fw-bold">Painel Admin</span>
                    </div>
                    
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu">
                        <li class="nav-item w-100">
                            <a href="#" class="nav-link text-white active">
                                <i class="fas fa-tachometer-alt fs-5"></i> <span  class="ms-1 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        
                        <li class="w-100">
                            <a href="{{ route('admin.edit.products') }}" class="nav-link text-white">
                                <i class="fas fa-edit fs-5"></i> <span class="ms-1 d-none d-sm-inline">Editar Produto</span>
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="{{ route('admin.add.product') }}" class="nav-link text-white">
                                <i class="fas fa-plus-circle fs-5"></i> <span class="ms-1 d-none d-sm-inline">Adicionar Produto</span>
                            </a>
                        </li>
                    </ul>
                    
                    <hr class="text-white">
                    
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face&auto=format" alt="Admin" width="35" height="35" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-2 fw-semibold">Administrador</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i>Perfil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Configurações</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="logout()"><i class="fas fa-sign-out-alt me-2"></i>Sair</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Conteúdo principal -->
            <div class="col py-4">
                <!-- Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h1 class="h3 mb-2">Painel Administrativo</h1>
                        <p class="text-muted">Gerencie o sistema e suas configurações</p>
                    </div>
                </div>

                <!-- Informações do Admin -->
                <div class="row mb-4">
                    <div class="col-lg-12 mb-4">
                        <div class="card dashboard-card h-100">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="admin-avatar">
                                            A
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h5 class="mb-1">Administrador</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                <!-- Ações Rápidas -->
                <div class="row">
                    <div class="col-12 mb-3">
                        <h5>Gerenciamento do Sistema</h5>
                    </div>
                    
                   

                    <div class="col-lg-6 col-md-6 mb-3">
                        <a href="{{ route('admin.edit.products') }}" class="quick-action">
                            <div class="card dashboard-card h-100">
                                <div class="card-body text-center">
                                    <div class="text-success mb-3">
                                        <i class="fas fa-edit fa-2x"></i>
                                    </div>
                                    <h6 class="card-title">Editar Produto</h6>
                                    <p class="card-text text-muted small">Modificar produtos existentes no catálogo</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-6 col-md-6 mb-3">
                        <a href="{{ route('admin.add.product') }}" class="quick-action">
                            <div class="card dashboard-card h-100">
                                <div class="card-body text-center">
                                    <div class="text-warning mb-3">
                                        <i class="fas fa-plus-circle fa-2x"></i>
                                    </div>
                                    <h6 class="card-title">Adicionar Produto</h6>
                                    <p class="card-text text-muted small">Cadastrar novos produtos no sistema</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    

                <!-- Atividades Recentes -->
                
    
    <!-- Botão de Logout Fixo -->
    <form action="{{ route('admin.logout') }}" method="GET" style="display:inline;">
        <button type="submit" class="btn logout-btn" title="Sair do Sistema">
            <i class="fas fa-sign-out-alt me-1"></i>Logout
        </button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @vite(['resources/js/adminDashboard'])
    </body>
    </html>