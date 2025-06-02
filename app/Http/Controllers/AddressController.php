<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Session;

class AddressController extends Controller
{
    /**
     * Retorna o endereço do usuário logado com base no ID da sessão.
     */
    public function show()
    {
        $userId = session::get('user_id'); // Ou auth()->id() se estiver usando Auth

        if (!$userId) {
            return redirect()->back()->with('error_message', 'Usuário não autenticado.');
        }

        $address = Address::where('user_id', $userId)->first();

        return view('user.addressShow', compact('address'));
    }

    /**
     * Valida e armazena o endereço do usuário na base de dados.
     */
    public function store(Request $request)
    {
        $userId = session::get('user_id');

        if (!$userId) {
            return redirect()->back()->with('error_message', 'Usuário não autenticado.');
        }

        $validated = $request->validate([
            'street'       => 'required|string|max:255',
            'number'       => 'required|string|max:20',
            'complement'   => 'nullable|string|max:100',
            'neighborhood' => 'required|string|max:100',
            'city'         => 'required|string|max:100',
            'state'        => 'required|string|max:2',
            'postal_code'  => 'required|string|max:10',
            'country'      => 'required|string|max:100',
        ]);

        $validated['user_id'] = $userId;

        Address::updateOrCreate(
            ['user_id' => $userId], // atualiza se já existir
            $validated
        );

        return redirect()->back()->with('success_message', 'Endereço salvo com sucesso!');
    }

    public function showForm(){
        return view('user.addressRegister');
    }
}
