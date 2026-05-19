@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">{{ $role->name }}</h1>
    <p class="text-base-content/60">Detalhes da função</p>
</div>

<div class="card bg-base-100 shadow-sm">
    <div class="card-body">
        <h2 class="card-title mb-4">Permissões</h2>
        @if ($role->permissions->isNotEmpty())
        <div class="flex flex-wrap gap-2">
            @foreach ($role->permissions as $permission)
                <span class="badge badge-soft badge-accent">{{ $permission->name }}</span>
            @endforeach
        </div>
        @else
        <p class="text-base-content/40">Nenhuma permissão atribuída.</p>
        @endif
    </div>
</div>
@endsection
