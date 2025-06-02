
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white d-flex align-items-center justify-content-center min-vh-100">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
        <div class="card shadow-sm p-4">
          <h4 class="text-center mb-4">Verificação de Código</h4>
          <form action="{{ route('user.register.confirmation.code.post',['email' => $email]) }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label">Digite o código de 6 dígitos</label>
              <input type="text" id="code" name="code" class="form-control text-center" maxlength="6" required />
            </div>
            <button type="submit" class="btn btn-success w-100">Verificar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
