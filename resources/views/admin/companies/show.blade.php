@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">{{ $company->nome_fantasia }}</h1>
    <p class="text-base-content/60">Detalhes da empresa</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-4">Informações</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm text-base-content/60">Razão Social:</span>
                        <p class="font-medium">{{ $company->razao_social }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-base-content/60">Nome Fantasia:</span>
                        <p class="font-medium">{{ $company->nome_fantasia }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-base-content/60">CNPJ:</span>
                        <p class="font-medium">{{ $company->cnpj }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-base-content/60">Plano:</span>
                        <p><span class="badge badge-soft
                            {{ $company->plano === 'business' ? 'badge-warning' : ($company->plano === 'pro' ? 'badge-info' : ($company->plano === 'starter' ? 'badge-success' : 'badge-ghost')) }}">
                            {{ ucfirst($company->plano) }}
                        </span></p>
                    </div>
                    <div>
                        <span class="text-sm text-base-content/60">Telefone:</span>
                        <p class="font-medium">{{ $company->telefone ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-base-content/60">Celular:</span>
                        <p class="font-medium">{{ $company->celular ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-base-content/60">E-mail:</span>
                        <p class="font-medium">{{ $company->email ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-base-content/60">Site:</span>
                        <p class="font-medium">{{ $company->site ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-base-content/60">Endereço:</span>
                        <p class="font-medium">{{ $company->endereco ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-base-content/60">Bairro:</span>
                        <p class="font-medium">{{ $company->bairro ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-base-content/60">Cidade/Estado:</span>
                        <p class="font-medium">{{ $company->cidade ?? '-' }}/{{ $company->estado ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-base-content/60">Status:</span>
                        <p>
                            @if ($company->ativo)
                                <span class="badge badge-soft badge-success">Ativo</span>
                            @else
                                <span class="badge badge-soft badge-error">Inativo</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if ($company->descricao)
                <div class="mt-4">
                    <span class="text-sm text-base-content/60">Descrição:</span>
                    <p class="mt-1">{{ $company->descricao }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <h2 class="card-title mb-4">Usuários</h2>
            @if ($company->users->isNotEmpty())
                <div class="space-y-3">
                    @foreach ($company->users as $user)
                    <div class="flex items-center gap-3">
                        <div class="avatar placeholder">
                            <div class="bg-neutral text-neutral-content rounded-full w-8">
                                <span class="text-xs">{{ substr($user->name, 0, 2) }}</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium">{{ $user->name }}</p>
                            <p class="text-xs text-base-content/60">{{ $user->email }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-base-content/40">Nenhum usuário vinculado.</p>
            @endif
        </div>
    </div>
</div>
@endsection
