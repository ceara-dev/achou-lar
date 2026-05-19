@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold">Usuários</h1>
        <p class="text-base-content/60">Lista de usuários do sistema</p>
    </div>
    @can('create users')
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Novo Usuário</a>
    @endcan
</div>

<div class="overflow-x-auto bg-base-100 rounded-box shadow-sm">
    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Funções</th>
                <th>Criado em</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            <tr>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="avatar placeholder">
                            <div class="bg-neutral text-neutral-content rounded-full w-8">
                                <span class="text-xs">{{ substr($user->name, 0, 2) }}</span>
                            </div>
                        </div>
                        <span class="font-medium">{{ $user->name }}</span>
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach ($user->roles as $role)
                        <span class="badge badge-soft badge-primary">{{ $role->name }}</span>
                    @endforeach
                </td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="flex gap-1">
                        @can('edit users')
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-ghost btn-sm">Editar</a>
                        @endcan
                        @can('delete users')
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                              onsubmit="return confirm('Excluir este usuário?')">
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
                <td colspan="5" class="text-center py-8 text-base-content/60">Nenhum usuário encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>
@endsection
