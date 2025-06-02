<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Endereço</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body class="bg-white d-flex align-items-center justify-content-center min-vh-100">

<div class="card shadow-sm p-4" style="width: 100%; max-width: 450px;">
    <h4 class="text-center mb-4">Cadastro de Endereço</h4>

    @if(session('success_message'))
        <div class="alert alert-success">
            {{ session('success_message') }}
        </div>
    @endif

    @if(session('error_message'))
        <div class="alert alert-danger">
            {{ session('error_message') }}
        </div>
    @endif

    <form action="{{ route('user.register.address.post') }}" method="POST" name="address-form">
        @csrf

        <div class="mb-3">
            <label class="form-label">Rua *</label>
            <input type="text" name="street" class="form-control" required value="{{ old('street') }}">
            @error('street')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Número *</label>
                <input type="text" name="number" class="form-control" required value="{{ old('number') }}">
                @error('number')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Complemento</label>
                <input type="text" name="complement" class="form-control" value="{{ old('complement') }}">
                @error('complement')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Bairro *</label>
            <input type="text" name="neighborhood" class="form-control" required value="{{ old('neighborhood') }}">
            @error('neighborhood')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Cidade *</label>
            <input type="text" name="city" class="form-control" required value="{{ old('city') }}">
            @error('city')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Estado (UF) *</label>
                <input type="text" name="state" class="form-control" maxlength="2" required value="{{ old('state') }}">
                @error('state')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">CEP *</label>
                <input type="text" name="postal_code" class="form-control" required placeholder="00000-000" value="{{ old('postal_code') }}">
                @error('postal_code')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">País *</label>
            <input type="text" name="country" class="form-control" required value="{{ old('country', 'Brasil') }}">
            @error('country')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success w-100">Salvar Endereço</button>
    </form>
</div>

</body>
</html>
