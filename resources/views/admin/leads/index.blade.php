@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Leads Recebidos</h1>
    <p class="text-base-content/60">Interessados nos seus imóveis</p>
</div>

@if(session('success'))
    <div class="alert alert-success mb-6">
        <span>{{ session('success') }}</span>
    </div>
@endif

@if($leads->isEmpty())
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body text-center py-16">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-base-content/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <h3 class="text-lg font-semibold mb-1">Nenhum lead recebido</h3>
            <p class="text-sm text-base-content/60">Quando alguém demonstrar interesse em seus imóveis, aparecerá aqui.</p>
        </div>
    </div>
@else
    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th></th>
                    <th>Interessado</th>
                    <th class="hidden md:table-cell">Contato</th>
                    <th>Imóvel</th>
                    <th class="hidden lg:table-cell">Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leads as $lead)
                    <tr class="{{ $lead->lido ? '' : 'font-semibold bg-base-200/50' }}">
                        <td>
                            @if(!$lead->lido)
                                <div class="w-2 h-2 rounded-full bg-primary"></div>
                            @endif
                        </td>
                        <td>
                            <div class="text-sm">{{ $lead->nome }}</div>
                            <div class="text-xs text-base-content/60 md:hidden">{{ $lead->email }} / {{ $lead->telefone }}</div>
                        </td>
                        <td class="hidden md:table-cell">
                            <div class="text-sm">{{ $lead->email }}</div>
                            <div class="text-xs text-base-content/60">{{ $lead->telefone }}</div>
                        </td>
                        <td>
                            <a href="{{ route('admin.leads.show', $lead) }}"
                               class="link link-hover text-sm font-medium">
                                {{ $lead->imovel->titulo ?? 'Imóvel removido' }}
                            </a>
                        </td>
                        <td class="hidden lg:table-cell text-sm">
                            {{ $lead->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            <div class="flex gap-1">
                                <a href="{{ route('admin.leads.show', $lead) }}"
                                   class="btn btn-ghost btn-xs">Ver</a>
                                <form method="POST" action="{{ route('admin.leads.unread', $lead) }}" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-ghost btn-xs"
                                            onclick="return confirm('Marcar como não lido?')">
                                        Não lido
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $leads->links() }}
    </div>
@endif
@endsection
