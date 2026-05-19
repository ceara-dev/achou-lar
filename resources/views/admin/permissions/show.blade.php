@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">{{ $permission->name }}</h1>
    <p class="text-base-content/60">Detalhes da permissão</p>
</div>

<div class="card bg-base-100 shadow-sm">
    <div class="card-body">
        <div class="space-y-3 mb-4">
            <div>
                <span class="text-sm text-base-content/60">Nome:</span>
                <p class="font-medium">{{ $permission->name }}</p>
            </div>
            <div>
                <span class="text-sm text-base-content/60">Guard:</span>
                <p class="font-medium">{{ $permission->guard_name }}</p>
            </div>
        </div>

        <h2 class="card-title mb-4">Funções com esta permissão</h2>
        @if ($permission->roles->isNotEmpty())
        <div class="flex flex-wrap gap-2">
            @foreach ($permission->roles as $role)
                <span class="badge badge-soft badge-primary">{{ $role->name }}</span>
            @endforeach
        </div>
        @else
        <p class="text-base-content/40">Nenhuma função possui esta permissão.</p>
        @endif
    </div>
</div>
@endsection
