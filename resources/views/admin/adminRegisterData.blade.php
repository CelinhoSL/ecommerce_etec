<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Administrador</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/showPassword.js', 'resources/css/register.css'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body class="bg-white d-flex align-items-center justify-content-center">
 <div class="card shadow-sm p-4" style="width: 100%; max-width: 350px;">
    <h4 class="text-center mb-4">Cadastro</h4>



    @if(session('error_message'))
            <div class="alert">
                {{ session('error_message') }}
            </div>
        @endif

    <form action="{{ route('admin.register.post', ['token' => $token]) }}" method="POST" name="register-form">
        @csrf
        <input type="hidden" name="token" value="{{ request()->query('token') }}">
        
        <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" id="username" name="username" class="form-control" required />
      </div>
      <div class="mb-3">
        <label class="form-label">E-mail</label>
        <input type="email" id="email" name="email" class="form-control" required />
      </div>
      <div class="mb-3">
        <label class="form-label">Senha</label>
        <div class="input-group">
          <input type="password" class="form-control" id="password" name="password" required />
          <span class="input-group-text" id="toggleSenha">
            <i class="bi bi-eye" id="iconeSenha"></i>
          </span>
        </div>
      </div>
      <button type="submit" class="btn btn-success w-100">Cadastrar</button>
    </form>
    <p class="text-center mt-3 small">
      Já tem conta? <a href="">Faça login</a>
    </p>
  </div>

    </form>


    


</body>
</html>
