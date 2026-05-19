@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Auditoria</h1>
    <p class="text-base-content/60">Registro de atividades do sistema</p>
</div>

<div class="overflow-x-auto bg-base-100 rounded-box shadow-sm">
    <table class="table">
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Evento</th>
                <th>Entidade</th>
                <th>Data</th>
                <th>IP</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($audits as $audit)
            <tr>
                <td>
                    @if ($audit->user)
                        <div class="flex items-center gap-2">
                            <div class="avatar placeholder">
                                <div class="bg-neutral text-neutral-content rounded-full w-6">
                                    <span class="text-[10px]">{{ substr($audit->user->name, 0, 2) }}</span>
                                </div>
                            </div>
                            <span class="text-sm">{{ $audit->user->name }}</span>
                        </div>
                    @else
                        <span class="text-sm text-base-content/40">Sistema</span>
                    @endif
                </td>
                <td>
                    @php
                        $eventClass = match($audit->event) {
                            'created' => 'badge-success',
                            'updated' => 'badge-info',
                            'deleted' => 'badge-error',
                            default => 'badge-ghost',
                        };
                    @endphp
                    <span class="badge badge-sm {{ $eventClass }}">{{ $audit->event }}</span>
                </td>
                <td>
                    <span class="text-sm">{{ class_basename($audit->auditable_type) }} #{{ $audit->auditable_id }}</span>
                </td>
                <td class="text-sm">{{ $audit->created_at->format('d/m/Y H:i') }}</td>
                <td class="text-sm">{{ $audit->ip_address ?? '-' }}</td>
                <td>
                    <a href="{{ route('admin.audits.show', $audit) }}" class="btn btn-ghost btn-sm">Detalhes</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-8 text-base-content/60">Nenhum registro de auditoria encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $audits->links() }}
</div>
@endsection
