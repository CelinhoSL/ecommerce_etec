<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function checkout($orderId)
    {
        $order = $this->getOrder($orderId);

        if (!$order) {
            return view('user/checkoutCart', [
                'order' => null,
                'pixCode' => null,
                'error' => 'Pedido não encontrado.'
            ]);
        }

        // ✅ GERAR PIX E ATUALIZAR O PEDIDO NO BANCO
        $pixCode = $this->generateAndSavePix($order);

        return view('user/checkoutCart', [
            'order' => $order,
            'pixCode' => $pixCode,
            'error' => null
        ]);
    }

    public function checkoutCart($orderId)
    {
        $order = $this->getOrder($orderId);

        if (!$order) {
            return view('user/checkoutCart', [
                'order' => null,
                'pixCode' => null,
                'error' => 'Pedido não encontrado.'
            ]);
        }

        // ✅ GERAR PIX E ATUALIZAR O PEDIDO NO BANCO
        $pixCode = $this->generateAndSavePix($order);

        return view('user/checkoutCart', [
            'order' => $order,
            'pixCode' => $pixCode,
            'error' => null
        ]);
    }

    private function getOrder($orderId)
    {
        try {
            // ✅ BUSCAR DADOS REAIS DO BANCO
            $realOrder = Order::with('orderItems.product')->findOrFail($orderId);
            
            // ✅ PREENCHER ARRAY COM DADOS REAIS
            $orderData = [
                'id' => $realOrder->id_order,
                'id_user' => $realOrder->id_user,
                'order_code' => $realOrder->order_code,
                'total_amount' => $realOrder->total_amount,
                'payment_method' => $realOrder->payment_method,
                'status' => $realOrder->status,
                'pix_key' => $realOrder->pix_key,
                'pix_code' => $realOrder->pix_code, // ✅ INCLUIR PIX_CODE DO BANCO
                'expires_at' => $realOrder->expires_at,
                'created_at' => $realOrder->created_at,
                'updated_at' => $realOrder->updated_at,
                'items' => $realOrder->orderItems, // ✅ INCLUIR ITENS DO PEDIDO
            ];

            return (object) $orderData;
            
        } catch (\Exception $e) {
            return null;
        }
    }

    private function generateAndSavePix($order)
    {
        // ✅ VERIFICAR SE JÁ TEM PIX_CODE VÁLIDO
        if (!empty($order->pix_code) && !str_contains($order->pix_code, 'fakepixcode')) {
            return $order->pix_code;
        }

        // ✅ GERAR NOVO PIX CODE
        $pixCode = $this->generatePix($order);

        // ✅ SALVAR NO BANCO DE DADOS
        Order::where('id_order', $order->id)->update([
            'pix_code' => $pixCode,
            'updated_at' => now()
        ]);

        // ✅ ATUALIZAR O OBJETO LOCAL
        $order->pix_code = $pixCode;

        return $pixCode;
    }

    private function generatePix($order)
    {
        // ✅ PIX GERADO DINAMICAMENTE COM DADOS REAIS
        $payload = '';
        $payload .= $this->formatField('00', '01');
        
        // ✅ CAMPO 26 - MERCHANT ACCOUNT INFORMATION
        $merchantInfo = '';
        $merchantInfo .= $this->formatField('00', 'br.gov.bcb.pix');
        $merchantInfo .= $this->formatField('01', $order->pix_key ?? '11999887766');
        $merchantInfo .= $this->formatField('02', 'Pedido ' . $order->order_code);
        $payload .= $this->formatField('26', $merchantInfo);
        
        $payload .= $this->formatField('52', '0000'); // Merchant Category Code
        $payload .= $this->formatField('53', '986');  // Transaction Currency (BRL)
        
        // ✅ VALOR REAL DO BANCO
        $payload .= $this->formatField('54', number_format($order->total_amount, 2, '.', ''));
        
        $payload .= $this->formatField('58', 'BR');   // Country Code
        $payload .= $this->formatField('59', 'LOJA TESTE'); // Merchant Name
        $payload .= $this->formatField('60', 'SAO PAULO');  // Merchant City
        
        // ✅ ADDITIONAL DATA FIELD
        $additionalData = $this->formatField('05', $order->order_code);
        $payload .= $this->formatField('62', $additionalData);
        
        // ✅ CRC16
        $payload .= '6304';
        $payload .= $this->calculateCRC16($payload);

        return $payload;
    }

    private function formatField($id, $value)
    {
        $length = str_pad(strlen($value), 2, '0', STR_PAD_LEFT);
        return $id . $length . $value;
    }

    private function calculateCRC16($data)
    {
        $polynomial = 0x1021;
        $crc = 0xFFFF;

        for ($i = 0; $i < strlen($data); $i++) {
            $crc ^= ord($data[$i]) << 8;
            for ($j = 0; $j < 8; $j++) {
                if ($crc & 0x8000) {
                    $crc = ($crc << 1) ^ $polynomial;
                } else {
                    $crc = $crc << 1;
                }
                $crc &= 0xFFFF;
            }
        }

        return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
    }
}