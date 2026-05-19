<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrato;
use App\Models\Pagamento;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    public function store(Request $request, Contrato $contrato)
    {
        $validated = $request->validate([
            'data_vencimento' => 'required|date',
            'data_pagamento' => 'nullable|date',
            'valor' => 'required|numeric|min:0',
            'atrasado' => 'nullable|boolean',
            'agua' => 'nullable|numeric|min:0',
            'energia' => 'nullable|numeric|min:0',
            'internet' => 'nullable|numeric|min:0',
            'observacao' => 'nullable|string|max:1000',
        ]);

        $validated['atrasado'] = $request->boolean('atrasado');

        $contrato->pagamentos()->create($validated);

        return back()->with('success', 'Pagamento registrado com sucesso.');
    }

    public function destroy(Pagamento $pagamento)
    {
        $pagamento->delete();
        return back()->with('success', 'Pagamento excluído com sucesso.');
    }
}
