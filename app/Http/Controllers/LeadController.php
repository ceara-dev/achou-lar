<?php

namespace App\Http\Controllers;

use App\Events\NewLeadReceived;
use App\Models\Imovel;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request, Imovel $imovel)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'mensagem' => 'nullable|string',
            'tipo_proposta' => 'required|in:alugar,comprar',
            'valor_proposta' => 'nullable|numeric|min:0',
        ]);

        $lead = Lead::create([
            'imovel_id' => $imovel->id,
            'user_id' => $imovel->user_id,
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'telefone' => $validated['telefone'],
            'mensagem' => $validated['mensagem'],
            'tipo_proposta' => $validated['tipo_proposta'],
            'valor_proposta' => $validated['valor_proposta'],
        ]);

        NewLeadReceived::dispatch($lead);

        return back()->with('success', 'Proposta enviada com sucesso! Entraremos em contato.');
    }
}
