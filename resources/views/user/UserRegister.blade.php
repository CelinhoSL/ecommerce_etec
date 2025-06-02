
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/showPassword.js', 'resources/css/register.css'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body class="bg-white d-flex align-items-center justify-content-center">

<div class="card shadow-sm p-4" style="width: 100%; max-width: 450px;">
    <h4 class="text-center mb-4">Cadastro de Usuário</h4>
    
    @if(session('error_message'))
        <div class="alert alert-danger">
            {{ session('error_message') }}
        </div>
    @endif

    <form action="{{ route('user.register.post') }}" method="POST" name="register-form">
        @csrf
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Nome *</label>
                <input type="text" id="first_name" name="first_name" class="form-control" required 
                       value="{{ old('first_name') }}" />
                @error('first_name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Sobrenome *</label>
                <input type="text" id="last_name" name="last_name" class="form-control" required 
                       value="{{ old('last_name') }}" />
                @error('last_name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Data de Nascimento *</label>
            <input type="date" id="birth_date" name="birth_date" class="form-control" required 
                   value="{{ old('birth_date') }}" />
            @error('birth_date')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Telefone *</label>
            <input type="tel" id="phone" name="phone" class="form-control" required 
                   placeholder="(00) 00000-0000" value="{{ old('phone') }}" />
            @error('phone')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">E-mail *</label>
            <input type="email" id="email" name="email" class="form-control" required 
                   value="{{ old('email') }}" />
            @error('email')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Senha *</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" required 
                       minlength="6" />
                <span class="input-group-text" id="toggleSenha" style="cursor: pointer;">
                    <i class="bi bi-eye" id="iconeSenha"></i>
                </span>
            </div>
            @error('password')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
            <div class="form-text small">Mínimo de 6 caracteres</div>
        </div>

        <div class="mb-4">
            <label class="form-label">Confirmar Senha *</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password_confirmation" 
                       name="password_confirmation" required minlength="6" />
                <span class="input-group-text" id="toggleConfirmSenha" style="cursor: pointer;">
                    <i class="bi bi-eye" id="iconeConfirmSenha"></i>
                </span>
            </div>
            @error('password_confirmation')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success w-100 mb-3">Cadastrar Usuário</button>
    </form>

    <p class="text-center mt-3 small">
       
    </p>
</div>