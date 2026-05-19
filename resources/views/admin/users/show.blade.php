@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
    <p class="text-base-content/60">Detalhes do usuário</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <h2 class="card-title mb-4">Informações</h2>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-base-content/60">Nome:</span>
                    <p class="font-medium">{{ $user->name }}</p>
                </div>
                <div>
                    <span class="text-sm text-base-content/60">E-mail:</span>
                    <p class="font-medium">{{ $user->email }}</p>
                </div>
                <div>
                    <span class="text-sm text-base-content/60">Criado em:</span>
                    <p class="font-medium">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <span class="text-sm text-base-content/60">Atualizado em:</span>
                    <p class="font-medium">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <h2 class="card-title mb-4">Funções e Permissões</h2>
            @foreach ($user->roles as $role)
            <div class="mb-4">
                <h3 class="font-medium badge badge-soft badge-primary mb-2">{{ $role->name }}</h3>
                <div class="flex flex-wrap gap-1 ml-2">
                    @forelse ($role->permissions as $permission)
                        <span class="badge badge-soft badge-accent badge-sm">{{ $permission->name }}</span>
                    @empty
                        <span class="text-sm text-base-content/40">Nenhuma permissão</span>
                    @endforelse
                </div>
            </div>
            @endforeach

            @if ($user->roles->isEmpty())
            <p class="text-sm text-base-content/40">Nenhuma função atribuída.</p>
            @endif
        </div>
    </div>
</div>
@endsection
