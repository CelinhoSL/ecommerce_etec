<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/showPassword.js'])
</head>
<body class="bg-light d-flex justify-content-center align-items-center min-vh-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-header bg-success text-white">
            <h4 class="mb-0 text-center">Acesso Administrativo</h4>
          </div>
          <div class="card-body">
            @if(session('error'))
              <div class="alert alert-danger">
                {{ session('error') }}
              </div>
            @endif

            @if(session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
            @endif

            <form method="POST" action="{{ route('user.login.post') }}">
              @csrf
              <div class="mb-3">
                <label for="username" class="form-label">Email do usuário</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-success">Entrar</button>
              </div>

                <div class="text-center mt-3">
                <a href="{{ route('user.register') }}">Cadastrar</a>
            </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
