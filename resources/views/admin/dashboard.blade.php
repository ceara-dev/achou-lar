@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Dashboard</h1>
    <p class="text-base-content/60">Bem-vindo, {{ auth()->user()->name }}!</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="stat bg-base-100 rounded-box shadow-sm">
        <div class="stat-title">Usuários</div>
        <div class="stat-value text-primary">{{\App\Models\User::count()}}</div>
    </div>
    <div class="stat bg-base-100 rounded-box shadow-sm">
        <div class="stat-title">Funções</div>
        <div class="stat-value text-secondary">{{ \Spatie\Permission\Models\Role::count() }}</div>
    </div>
    <div class="stat bg-base-100 rounded-box shadow-sm">
        <div class="stat-title">Permissões</div>
        <div class="stat-value text-accent">{{ \Spatie\Permission\Models\Permission::count() }}</div>
    </div>
    <div class="stat bg-base-100 rounded-box shadow-sm">
        <div class="stat-title">Auditorias</div>
        <div class="stat-value">{{ \OwenIt\Auditing\Models\Audit::count() }}</div>
    </div>
</div>
@endsection
