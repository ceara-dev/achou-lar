@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h1 class="text-2xl font-bold">Lead</h1>
        <p class="text-base-content/60">Detalhes do contato recebido</p>
    </div>
    <a href="{{ route('admin.leads.index') }}" class="btn btn-ghost">
        Voltar
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title">Dados do Contato</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-base-content/60">Nome</label>
                        <p class="font-medium">{{ $lead->nome }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Email</label>
                        <p class="font-medium">
                            <a href="mailto:{{ $lead->email }}" class="link link-hover">{{ $lead->email }}</a>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Telefone</label>
                        <p class="font-medium">
                            <a href="tel:{{ $lead->telefone }}" class="link link-hover">{{ $lead->telefone }}</a>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Recebido em</label>
                        <p class="font-medium">{{ $lead->created_at->format('d/m/Y \à\s H:i') }}</p>
                    </div>
                </div>

                @if($lead->mensagem)
                    <div class="mt-4">
                        <label class="text-sm text-base-content/60">Mensagem</label>
                        <p class="mt-1 p-4 bg-base-200 rounded-box whitespace-pre-wrap">{{ $lead->mensagem }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title">Imóvel</h2>
                <p class="font-medium">{{ $lead->imovel->titulo ?? 'Imóvel removido' }}</p>
                @if($lead->imovel)
                    <p class="text-sm text-base-content/60 mt-1">
                        {{ $lead->imovel->endereco }}, {{ $lead->imovel->cidade }}/{{ $lead->imovel->estado }}
                    </p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="badge badge-ghost">{{ $lead->imovel->categoria?->nome }}</span>
                        <span class="badge badge-ghost">{{ $lead->imovel->tipoNegocio?->nome }}</span>
                    </div>
                    <div class="mt-4 flex gap-2">
                        @if($lead->imovel->fotoCapa)
                            <a href="{{ route('admin.imoveis.index') }}" class="btn btn-outline btn-sm">
                                Ver imóvel
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('admin.leads.unread', $lead) }}">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-outline w-full">
                Marcar como não lido
            </button>
        </form>
    </div>
</div>
@endsection
