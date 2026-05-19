@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold">Funções</h1>
        <p class="text-base-content/60">Gerenciamento de funções do sistema</p>
    </div>
    @can('create roles')
    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">Nova Função</a>
    @endcan
</div>

<div class="overflow-x-auto bg-base-100 rounded-box shadow-sm">
    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Permissões</th>
                <th>Usuários</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($roles as $role)
            <tr>
                <td class="font-medium">{{ $role->name }}</td>
                <td>
                    <div class="flex flex-wrap gap-1">
                        @foreach ($role->permissions as $permission)
                            <span class="badge badge-soft badge-accent badge-sm">{{ $permission->name }}</span>
                        @endforeach
                    </div>
                </td>
                <td>{{ $role->users_count }}</td>
                <td>
                    <div class="flex gap-1">
                        @can('edit roles')
                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-ghost btn-sm">Editar</a>
                        @endcan
                        @can('delete roles')
                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}"
                              onsubmit="return confirm('Excluir esta função?')">
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
                <td colspan="4" class="text-center py-8 text-base-content/60">Nenhuma função encontrada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $roles->links() }}
</div>
@endsection
