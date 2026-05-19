@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h1 class="text-2xl font-bold">Meus Imóveis</h1>
        <p class="text-base-content/60">Gerencie seus anúncios publicados</p>
    </div>
    <a href="{{ route('imovel.create') }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Novo Imóvel
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success mb-6">
        <span>{{ session('success') }}</span>
    </div>
@endif

@if($imoveis->isEmpty())
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body text-center py-16">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-base-content/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <h3 class="text-lg font-semibold mb-1">Nenhum imóvel anunciado</h3>
            <p class="text-sm text-base-content/60 mb-4">Você ainda não publicou nenhum anúncio.</p>
            <a href="{{ route('imovel.create') }}" class="btn btn-primary">Anunciar Imóvel</a>
        </div>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($imoveis as $imovel)
            <div class="card bg-base-100 shadow-sm">
                <figure class="aspect-video bg-base-300 relative">
                    @if($imovel->fotoCapa)
                        <img src="{{ asset('storage/' . $imovel->fotoCapa->caminho) }}"
                             class="w-full h-full object-cover" alt="{{ $imovel->titulo }}" />
                    @else
                        <div class="flex items-center justify-center w-full h-full text-base-content/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-2 right-2">
                        @if($imovel->status === 'active')
                            <span class="badge badge-success badge-sm">Ativo</span>
                        @elseif($imovel->status === 'sold')
                            <span class="badge badge-error badge-sm">Vendido</span>
                        @elseif($imovel->status === 'rented')
                            <span class="badge badge-info badge-sm">Alugado</span>
                        @else
                            <span class="badge badge-ghost badge-sm">Inativo</span>
                        @endif
                    </div>
                </figure>
                <div class="card-body p-4">
                    <div class="flex items-start justify-between gap-2 mb-1">
                        <h3 class="font-semibold truncate">{{ $imovel->titulo }}</h3>
                    </div>
                    <p class="text-sm text-base-content/60 truncate">
                        {{ $imovel->cidade }}, {{ $imovel->estado }}
                    </p>
                    <p class="text-lg font-bold text-primary mt-1">{{ $imovel->precoFormatado }}</p>
                    <div class="flex flex-wrap gap-3 text-xs text-base-content/60 mt-2">
                        @if($imovel->area)
                            <span>{{ $imovel->areaFormatada }}</span>
                        @endif
                        @if($imovel->quartos)
                            <span>{{ $imovel->quartos }} quarto(s)</span>
                        @endif
                        @if($imovel->banheiros)
                            <span>{{ $imovel->banheiros }} banheiro(s)</span>
                        @endif
                        @if($imovel->cozinhas)
                            <span>{{ $imovel->cozinhas }} cozinha(s)</span>
                        @endif
                        @if($imovel->vagas)
                            <span>{{ $imovel->vagas }} vaga(s)</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 mt-3 pt-3 border-t border-base-200">
                        <span class="badge badge-ghost badge-sm">{{ $imovel->categoria?->nome }}</span>
                        <span class="badge badge-ghost badge-sm">{{ $imovel->tipoNegocio?->nome }}</span>
                        @if($imovel->tipo_residencia)
                            <span class="badge badge-ghost badge-sm capitalize">{{ $imovel->tipo_residencia }}</span>
                        @endif
                        <span class="text-xs text-base-content/40 ml-auto">{{ $imovel->views }} visualizações</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $imoveis->links() }}
    </div>
@endif
@endsection
