<?php


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="bg-white d-flex align-items-center justify-content-center">

  <div class="card shadow-sm p-4" style="width: 100%; max-width: 350px;">
    <h4 class="text-center mb-4">Verificação de Código</h4>
    <form action="{{ route('admin.confirm.code.post',['token' => $token]) }}" method="POST">
    @csrf
      <div class="mb-3">
        <label class="form-label">Digite o código de 6 dígitos</label>
        <input type="text" id="code" name="code" class="form-control text-center" maxlength="6" required />
      </div>
      <button type="submit" class="btn btn-success w-100">Verificar</button>
    </form>
   
  </div>

  


</body>
</html>