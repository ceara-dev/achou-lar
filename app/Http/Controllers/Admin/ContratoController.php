<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrato;
use App\Models\Imovel;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function store(Request $request, Imovel $imovel)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'acao' => 'required|in:comprar,alugar',
            'tipo' => 'required|string|max:50',
            'valor' => 'required|numeric|min:0',
            'data' => 'required|date',
            'inicio' => 'required|date',
            'prazo' => 'required|integer|min:1',
            'arquivo' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        if ($request->hasFile('arquivo')) {
            $validated['arquivo'] = $request->file('arquivo')->store('contratos/' . $imovel->id, 'public');
        }

        $imovel->contratos()->create($validated);

        return back()->with('success', 'Contrato cadastrado com sucesso.');
    }

    public function destroy(Contrato $contrato)
    {
        $contrato->delete();
        return back()->with('success', 'Contrato excluído com sucesso.');
    }
}
