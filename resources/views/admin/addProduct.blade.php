<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Produto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  <form action="{{ route('admin.add.product.post') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="container my-5">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">

        <h2 class="mb-4">Adicionar Produto</h2>

        @if($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


          <div class="mb-3">
            <label class="form-label">Nome do Produto *</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
          </div>

          <div class="mb-3">
            <label class="form-label">Descrição *</label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
          </div>

          <div class="row mb-3">
            <div class="col-md-6 mb-2">
              <label class="form-label">Preço *</label>
              <input type="number" name="price" step="0.01" class="form-control" required value="{{ old('price') }}">
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label">Quantidade *</label>
              <input type="number" name="quantity" class="form-control" required value="{{ old('quantity') }}">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Status *</label>
            <select name="status" class="form-control" required>
              <option value="">Selecione...</option>
              <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Ativo</option>
              <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inativo</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Slug (opcional)</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
          </div>

          <div class="row mb-3">
            <div class="col-md-4 mb-2">
              <label class="form-label">Tamanho</label>
              <input type="text" name="size" class="form-control" value="{{ old('size') }}">
            </div>
            <div class="col-md-4 mb-2">
              <label class="form-label">Cor</label>
              <input type="text" name="color" class="form-control" value="{{ old('color') }}">
            </div>
            <div class="col-md-4 mb-2">
              <label class="form-label">Peso</label>
              <input type="text" name="weight" class="form-control" value="{{ old('weight') }}">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6 mb-2">
              <label class="form-label">Altura</label>
              <input type="text" name="height" class="form-control" value="{{ old('height') }}">
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label">Largura</label>
              <input type="text" name="width" class="form-control" value="{{ old('width') }}">
            </div>
          </div>


          <div class="mb-3">
            <label class="form-label">Categoria *</label>
            <input type="text" name="category" class="form-control" required value="{{ old('category') }}">
          </div>

          <div class="mb-3">
            <label class="form-label">Imagem do Produto *</label>
            <div class="input-group">
              <input type="file" class="form-control d-none" name="image" id="imageInput" accept="image/*" required>
              <label for="imageInput" class="btn btn-outline-primary">
                <i class="bi bi-upload"></i> Escolher imagem
              </label>
            </div>
            <div id="imagePreview" class="mt-3 text-center d-none">
              <img src="#" alt="Pré-visualização" class="img-fluid rounded" style="max-height: 200px;">
            </div>
          </div>

          <button type="submit" class="btn btn-success w-100">Salvar Produto</button>

        </div>
      </div>
    </div>
  </form>

  @vite(['resources/js/imagePreview.js'])
</body>
</html>
