@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Detalhes da Auditoria</h1>
    <p class="text-base-content/60">Registro #{{ $audit->id }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <h2 class="card-title mb-4">Informações</h2>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-base-content/60">Usuário:</span>
                    <p class="font-medium">{{ $audit->user->name ?? 'Sistema' }}</p>
                </div>
                <div>
                    <span class="text-sm text-base-content/60">Evento:</span>
                    @php
                        $eventClass = match($audit->event) {
                            'created' => 'badge-success',
                            'updated' => 'badge-info',
                            'deleted' => 'badge-error',
                            default => 'badge-ghost',
                        };
                    @endphp
                    <p><span class="badge {{ $eventClass }}">{{ $audit->event }}</span></p>
                </div>
                <div>
                    <span class="text-sm text-base-content/60">Entidade:</span>
                    <p class="font-medium">{{ $audit->auditable_type }} #{{ $audit->auditable_id }}</p>
                </div>
                <div>
                    <span class="text-sm text-base-content/60">Data:</span>
                    <p class="font-medium">{{ $audit->created_at->format('d/m/Y H:i:s') }}</p>
                </div>
                <div>
                    <span class="text-sm text-base-content/60">IP:</span>
                    <p class="font-medium">{{ $audit->ip_address ?? '-' }}</p>
                </div>
                <div>
                    <span class="text-sm text-base-content/60">URL:</span>
                    <p class="font-medium text-sm break-all">{{ $audit->url ?? '-' }}</p>
                </div>
                <div>
                    <span class="text-sm text-base-content/60">User Agent:</span>
                    <p class="font-medium text-xs break-all">{{ $audit->user_agent ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <h2 class="card-title mb-4">Alterações</h2>

            @if ($audit->old_values || $audit->new_values)
                @foreach (array_keys($audit->new_values ?: $audit->old_values) as $field)
                <div class="mb-4 p-3 bg-base-200 rounded-box">
                    <p class="text-sm font-medium mb-1">{{ $field }}</p>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div>
                            <span class="text-error text-xs font-medium">Antigo</span>
                            <p class="truncate">{{ json_encode($audit->old_values[$field] ?? '-') }}</p>
                        </div>
                        <div>
                            <span class="text-success text-xs font-medium">Novo</span>
                            <p class="truncate">{{ json_encode($audit->new_values[$field] ?? '-') }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <p class="text-base-content/40">Nenhuma alteração registrada.</p>
            @endif
        </div>
    </div>
</div>
@endsection
