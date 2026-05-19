@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold">Empresas</h1>
        <p class="text-base-content/60">Imobiliárias e corretores cadastrados</p>
    </div>
    @can('create companies')
    <a href="{{ route('admin.companies.create') }}" class="btn btn-primary">Nova Empresa</a>
    @endcan
</div>

<div class="overflow-x-auto bg-base-100 rounded-box shadow-sm">
    <table class="table">
        <thead>
            <tr>
                <th>Empresa</th>
                <th>CNPJ</th>
                <th>Contato</th>
                <th>Plano</th>
                <th>Usuários</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($companies as $company)
            <tr>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="avatar placeholder">
                            <div class="bg-neutral text-neutral-content rounded-box w-10">
                                <span class="text-xs">{{ substr($company->nome_fantasia, 0, 2) }}</span>
                            </div>
                        </div>
                        <div>
                            <span class="font-medium">{{ $company->nome_fantasia }}</span>
                            <p class="text-xs text-base-content/60">{{ $company->razao_social }}</p>
                        </div>
                    </div>
                </td>
                <td class="text-sm">{{ $company->cnpj }}</td>
                <td>
                    <div class="text-sm">
                        <p>{{ $company->telefone ?? '-' }}</p>
                        <p class="text-xs text-base-content/60">{{ $company->email ?? '-' }}</p>
                    </div>
                </td>
                <td>
                    <span class="badge badge-soft
                        {{ $company->plano === 'business' ? 'badge-warning' : ($company->plano === 'pro' ? 'badge-info' : ($company->plano === 'starter' ? 'badge-success' : 'badge-ghost')) }}">
                        {{ ucfirst($company->plano) }}
                    </span>
                </td>
                <td>{{ $company->users_count }}</td>
                <td>
                    @if ($company->ativo)
                        <span class="badge badge-soft badge-success">Ativo</span>
                    @else
                        <span class="badge badge-soft badge-error">Inativo</span>
                    @endif
                </td>
                <td>
                    <div class="flex gap-1">
                        <a href="{{ route('admin.companies.show', $company) }}" class="btn btn-ghost btn-sm">Ver</a>
                        @can('edit companies')
                        <a href="{{ route('admin.companies.edit', $company) }}" class="btn btn-ghost btn-sm">Editar</a>
                        @endcan
                        @can('delete companies')
                        <form method="POST" action="{{ route('admin.companies.destroy', $company) }}"
                              onsubmit="return confirm('Excluir esta empresa?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-ghost btn-sm text-error">Excluir</button>
                        </form>
                        @endcan
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-8 text-base-content/60">Nenhuma empresa encontrada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $companies->links() }}
</div>
@endsection
