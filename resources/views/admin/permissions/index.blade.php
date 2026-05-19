@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Permissões</h1>
    <p class="text-base-content/60">Lista de permissões do sistema</p>
</div>

<div class="overflow-x-auto bg-base-100 rounded-box shadow-sm">
    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Guard</th>
                <th>Funções com esta permissão</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($permissions as $permission)
            <tr>
                <td class="font-medium">{{ $permission->name }}</td>
                <td><span class="badge badge-soft">{{ $permission->guard_name }}</span></td>
                <td>
                    <div class="flex flex-wrap gap-1">
                        @forelse ($permission->roles as $role)
                            <span class="badge badge-soft badge-primary badge-sm">{{ $role->name }}</span>
                        @empty
                            <span class="text-sm text-base-content/40">Nenhuma</span>
                        @endforelse
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center py-8 text-base-content/60">Nenhuma permissão encontrada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $permissions->links() }}
</div>
@endsection
