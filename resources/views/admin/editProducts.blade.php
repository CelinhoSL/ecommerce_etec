<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário com Busca</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #suggestionsList {
            display: none;
            position: absolute;
            z-index: 1050;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
        }
        .list-group-item-action:hover {
            cursor: pointer;
            background-color: #f8f9fa;
        }
        .product-actions {
            display: none;
            margin-top: 15px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>

<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <h2 class="mb-4">Editar Produtos</h2>

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

            <!-- Campo de busca -->
            <div class="mb-4 position-relative">
                <label for="searchInput" class="form-label">Buscar Produto</label>
                <input type="text" id="searchInput" name="searchInput" class="form-control" placeholder="Digite o nome do produto...">
                <ul id="suggestionsList" class="list-group"></ul>
            </div>

            <!-- Ações do produto selecionado -->
            <div id="productActions" class="product-actions">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Produto Selecionado: <span id="selectedProductName"></span></h5>
                    <button type="button" id="clearSelection" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-x"></i> Limpar
                    </button>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <button type="button" id="editProduct" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Editar Produto
                    </button>
                    <button type="button" id="deleteProduct" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Excluir Produto
                    </button>
                </div>
            </div>

            <!-- Formulário de edição (inicialmente oculto) -->
            <form id="productForm" action="{{ route('admin.edit.products.post') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Descrição *</label>
                    <textarea name="description" class="form-control" rows="3" >{{ old('description') }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Preço *</label>
                        <input type="number" name="price" step="0.01" class="form-control"  value="{{ old('price') }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="quantidade" class="form-label">Quantidade *</label>
                        <input type="number" name="quantidade" id="quantidade" class="form-control"  value="{{ old('quantidade') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-control">
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
                    <input type="text" name="category" class="form-control"  value="{{ old('category') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagem do Produto *</label>
                    <div class="input-group">
                        <input type="file" class="form-control d-none" name="image" id="imageInput" accept="image/*" >
                        <label for="imageInput" class="btn btn-outline-primary">
                            <i class="bi bi-upload"></i> Escolher imagem
                        </label>
                    </div>
                    <div id="imagePreview" class="mt-3 text-center d-none">
                        <img src="#" alt="Pré-visualização" class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" id="cancelEdit" class="btn btn-secondary">Cancelar</button>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </div>
            </form>

            <!-- Formulário de exclusão (oculto) -->
            <form id="deleteForm" action="{{ route('admin.edit.products.delete') }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
                <input type="hidden" name="product_id" id="deleteProductId">
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    
$(document).ready(function() {
    // Variável para armazenar o produto selecionado
    let selectedProduct = null;

    // Busca de produtos
    $('#searchInput').on('input', function() {
        const query = $(this).val().trim();
        const suggestionsList = $('#suggestionsList');

        if (query.length < 2) {
            suggestionsList.hide().empty();
            return;
        }

        $.ajax({
            url: '{{ route("products.ajaxSearch") }}',
            type: 'GET',
            data: { search: query },
            success: function(data) {
                suggestionsList.empty();

                if (data.length === 0) {
                    suggestionsList.append('<li class="list-group-item disabled">Nenhum produto encontrado</li>');
                } else {
                    data.forEach(function(product) {
                        // Verifica tanto jid_product quanto id
                        const productId = product.jid_product || product.id;
                        if (!productId) {
                            console.error('Produto sem ID válido:', product);
                            return;
                        }
                        
                        suggestionsList.append(
                            `<li class="list-group-item list-group-item-action" 
                                data-id="${productId}" 
                                data-name="${product.name}">
                                ${product.name}
                            </li>`
                        );
                    });
                }
                suggestionsList.show();
            },
            error: function(xhr) {
                console.error('Erro na busca:', xhr.responseText);
                suggestionsList.empty().append(
                    '<li class="list-group-item text-danger">Erro ao buscar produtos</li>'
                ).show();
            }
        });
    });

    // Seleção de produto
    $(document).on('click', '#suggestionsList li[data-id]', function() {
        const productId = $(this).data('id');
        const productName = $(this).data('name');
        
        if (!productId) {
            console.error('ID do produto não encontrado');
            return;
        }
        
        selectedProduct = {
            id: productId,
            name: productName
        };
        
        $('#searchInput').val(productName);
        $('#suggestionsList').hide();
        $('#selectedProductName').text(productName);
        $('#productActions').show();
        
        console.log('Produto selecionado:', selectedProduct);
    });

    // Limpar seleção
    $('#clearSelection').on('click', function() {
        selectedProduct = null;
        $('#searchInput').val('');
        $('#productActions').hide();
        $('#productForm').hide();
        $('input[name="product_id"]').remove();
    });

    // Mostrar formulário de edição
    $('#editProduct').on('click', function() {
        if (!selectedProduct) return;
        
        // Remove qualquer campo product_id existente
        $('input[name="product_id"]').remove();
        
        // Adiciona o campo oculto ao formulário
        $('#productForm').append(
            `<input type="hidden" name="product_id" value="${selectedProduct.id}">`
        );
        
        $('#productForm').show();
    });

    // Cancelar edição
    $('#cancelEdit').on('click', function() {
        $('#productForm').hide();
        $('input[name="product_id"]').remove();
    });

    // Excluir produto
    $('#deleteProduct').on('click', function() {
        if (!selectedProduct) return;
        
        const confirmDelete = confirm(`Tem certeza que deseja excluir o produto "${selectedProduct.name}"?\n\nEsta ação não pode ser desfeita.`);
        
        if (confirmDelete) {
            $('#deleteProductId').val(selectedProduct.id);
            $('#deleteForm').submit();
        }
    });

    // Esconder sugestões ao clicar fora
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#searchInput, #suggestionsList').length) {
            $('#suggestionsList').hide();
        }
    });

    // Preview da imagem
    $('#imageInput').on('change', function(e) {
        const file = e.target.files[0];
        const preview = $('#imagePreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.find('img').attr('src', e.target.result);
                preview.removeClass('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            preview.addClass('d-none');
        }
    });

    // Validação antes do envio
    $('#productForm').on('submit', function(e) {
        if (!selectedProduct || !selectedProduct.id) {
            e.preventDefault();
            alert('Por favor, selecione um produto da lista antes de enviar.');
            $('#searchInput').focus();
            return false;
        }
        
        console.log('Enviando formulário com:', {
            product_id: selectedProduct.id,
            product_name: selectedProduct.name
        });
    });
});


</script>     

@vite(['resources/js/imagePreview.js'])
</body>
</html>