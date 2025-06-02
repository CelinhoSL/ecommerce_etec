<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

@vite(['resources/css/app.css', 'resources/js/app.js'])

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Endereço do Usuário</h5>
                    <a href="{{ route('user.register.address') }}" class="btn btn-sm btn-primary">
                        Registrar Novo Endereço
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success_message'))
                        <div class="alert alert-success">{{ session('success_message') }}</div>
                    @elseif(session('error_message'))
                        <div class="alert alert-danger">{{ session('error_message') }}</div>
                    @endif

                    @if($address)
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Rua</th>
                                    <td>{{ $address->street }}</td>
                                </tr>
                                <tr>
                                    <th>Numbero</th>
                                    <td>{{ $address->number }}</td>
                                </tr>
                                <tr>
                                    <th>Complemento</th>
                                    <td>{{ $address->complement ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Bairro</th>
                                    <td>{{ $address->neighborhood }}</td>
                                </tr>
                                <tr>
                                    <th>Cidade</th>
                                    <td>{{ $address->city }}</td>
                                </tr>
                                <tr>
                                    <th>Estado</th>
                                    <td>{{ $address->state }}</td>
                                </tr>
                                <tr>
                                    <th>Código Postal</th>
                                    <td>{{ $address->postal_code }}</td>
                                </tr>
                                <tr>
                                    <th>País</th>
                                    <td>{{ $address->country }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">Nenhum endereço cadastrado ainda.</p>
                        <a href="{{ route('user.register.address') }}" class="btn btn-outline-primary mt-2">
                            Registrar Novo Endereço
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>