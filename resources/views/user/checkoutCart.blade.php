<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Finalizar Pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .checkout-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .error {
            color: #dc3545;
            background: #f8d7da;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .order-info {
            background: #e8f5e8;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #28a745;
        }
        .order-code {
            font-size: 1.3em;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 10px;
        }
        .total-amount {
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
            margin: 15px 0;
        }
        .pix-section {
            background: #fff3cd;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ffeaa7;
            margin: 20px 0;
        }
        .pix-title {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 15px;
            color: #856404;
        }
        .pix-code {
            width: 100%;
            min-height: 80px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            font-family: monospace;
            font-size: 0.9em;
            background: #f8f9fa;
            resize: vertical;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        .qr-code img {
            max-width: 200px;
            border: 2px solid #ddd;
            border-radius: 8px;
        }
        .expires-info {
            background: #fff3cd;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
            text-align: center;
            color: #856404;
            font-weight: bold;
        }
        .copy-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .copy-btn:hover {
            background: #0056b3;
        }
        .product-info {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <h1>Finalizar Pedido</h1>

        @if (session('error'))
            <div class="error">
                {{ session('error') }}
            </div>
        @endif

        @if (isset($order))
            <div class="order-info">
                <div class="order-code">
                    Pedido: {{ $order->order_code }}
                </div>
                
                @if (isset($product) && isset($quantity))
                    <div class="product-info">
                        <strong>Produto:</strong> {{ $product->name ?? 'Produto' }}<br>
                        <strong>Quantidade:</strong> {{ $quantity }}
                    </div>
                @endif

                <div class="total-amount">
                    Total: R$ {{ number_format($order->total_amount, 2, ',', '.') }}
                </div>

                <p><strong>Método de Pagamento:</strong> {{ strtoupper($order->payment_method) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>

            @if ($order->payment_method === 'pix')
                <div class="pix-section">
                    <div class="pix-title">
                        💳 Pagamento via PIX
                    </div>
                    
                    <p><strong>Chave PIX:</strong> {{ $order->pix_key }}</p>
                    
                    <p><strong>Código PIX para Copia e Cola:</strong></p>
                    <textarea 
                        id="pixCode" 
                        class="pix-code" 
                        readonly 
                        rows="4"
                    >{{ $order->pix_code }}</textarea>
                    
                    <button class="copy-btn" onclick="copyPixCode()">
                        📋 Copiar Código PIX
                    </button>


                    @if ($order->expires_at)
                        <div class="expires-info">
                            ⏰ Este PIX expira em: {{ $order->expires_at->format('d/m/Y H:i:s') }}
                        </div>
                    @endif
                </div>
            @endif

            <div style="margin-top: 30px; text-align: center;">
                <p>Após realizar o pagamento, seu pedido será processado automaticamente.</p>
                <a href="{{ route('user.dashboard') }}" style="color: #007bff; text-decoration: none;">
                    ← Voltar ao Dashboard
                </a>
            </div>

        @else
            <div class="error">
                Pedido não encontrado ou dados incompletos.
            </div>
        @endif
    </div>

    <script>
        function copyPixCode() {
            const pixCodeElement = document.getElementById('pixCode');
            pixCodeElement.select();
            pixCodeElement.setSelectionRange(0, 99999); // Para dispositivos móveis
            
            try {
                document.execCommand('copy');
                alert('Código PIX copiado para área de transferência!');
            } catch (err) {
                alert('Erro ao copiar código. Copie manualmente.');
            }
        }

        // Auto-refresh para verificar status do pagamento (opcional)
        setTimeout(function() {
            console.log('Verificando status do pagamento...');
            // Aqui você pode implementar uma verificação AJAX
        }, 30000); // Verifica a cada 30 segundos
    </script>
</body>
</html>