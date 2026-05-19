@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Nova Função</h1>
    <p class="text-base-content/60">Crie uma nova função e atribua permissões</p>
</div>

<div class="card bg-base-100 shadow-sm max-w-xl">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.roles.store') }}">
            @csrf

            <div class="form-control mb-6">
                <label class="label" for="name">
                    <span class="label-text">Nome da Função</span>
                </label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       class="input input-bordered w-full @error('name') input-error @enderror" required />
                @error('name')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                @enderror
            </div>

            <div class="form-control mb-6">
                <label class="label">
                    <span class="label-text">Permissões</span>
                </label>
                <div class="space-y-3">
                    @foreach ($permissions as $group => $groupPermissions)
                    <div>
                        <h3 class="font-medium text-sm text-base-content/60 mb-2 capitalize">{{ $group }}</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($groupPermissions as $permission)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                       class="checkbox checkbox-primary checkbox-sm"
                                       {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }} />
                                <span class="text-sm">{{ $permission->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                @error('permissions')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
