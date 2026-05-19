@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Novo Usuário</h1>
    <p class="text-base-content/60">Preencha os dados do novo usuário</p>
</div>

<div class="card bg-base-100 shadow-sm max-w-lg">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="form-control mb-4">
                <label class="label" for="name">
                    <span class="label-text">Nome</span>
                </label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       class="input input-bordered w-full @error('name') input-error @enderror" required />
                @error('name')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                @enderror
            </div>

            <div class="form-control mb-4">
                <label class="label" for="email">
                    <span class="label-text">E-mail</span>
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="input input-bordered w-full @error('email') input-error @enderror" required />
                @error('email')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                @enderror
            </div>

            <div class="form-control mb-4">
                <label class="label" for="password">
                    <span class="label-text">Senha</span>
                </label>
                <div class="relative">
                    <input id="password" type="password" name="password"
                           class="input input-bordered w-full pr-10 @error('password') input-error @enderror" required />
                    <button type="button" data-password-toggle="password"
                            class="absolute right-2 top-1/2 -translate-y-1/2 btn btn-ghost btn-xs px-2">
                        <svg data-eye-open class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg data-eye-closed class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                @enderror
            </div>

            <div class="form-control mb-4">
                <label class="label" for="password_confirmation">
                    <span class="label-text">Confirmar Senha</span>
                </label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="input input-bordered w-full pr-10" required />
                    <button type="button" data-password-toggle="password_confirmation"
                            class="absolute right-2 top-1/2 -translate-y-1/2 btn btn-ghost btn-xs px-2">
                        <svg data-eye-open class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg data-eye-closed class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-control mb-6">
                <label class="label">
                    <span class="label-text">Funções</span>
                </label>
                <div class="flex flex-wrap gap-2">
                    @foreach ($roles as $role)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                               class="checkbox checkbox-primary checkbox-sm"
                               {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }} />
                        <span class="text-sm">{{ $role->name }}</span>
                    </label>
                    @endforeach
                </div>
                @error('roles')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
