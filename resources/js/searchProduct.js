
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

