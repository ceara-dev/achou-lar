@extends('layouts.guest')

@section('title', config('app.name') . ' - Login')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="card w-full max-w-md bg-base-100 shadow-xl">
        <div class="card-body p-8">
            <div class="text-center mb-8">
                <a href="{{ url('/') }}" class="text-2xl font-bold mb-2 block">{{ config('app.name') }}</a>
                <p class="text-base-content/60">Faça login para continuar</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-control mb-4">
                    <label class="label" for="email">
                        <span class="label-text">E-mail</span>
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           class="input input-bordered w-full @error('email') input-error @enderror"
                           required autofocus autocomplete="username"
                           placeholder="seu@email.com" />
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
                               class="input input-bordered w-full pr-10 @error('password') input-error @enderror"
                               required autocomplete="current-password"
                               placeholder="••••••••" />
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

                <div class="form-control mb-6">
                    <label class="label cursor-pointer justify-start gap-2">
                        <input type="checkbox" name="remember" class="checkbox checkbox-primary" />
                        <span class="label-text">Lembrar de mim</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-full">Entrar</button>
            </form>

            <div class="divider my-6">ou</div>

            <div class="text-center">
                <p class="text-sm text-base-content/60 mb-2">Não tem uma conta?</p>
                <a href="{{ route('register') }}" class="btn btn-outline btn-sm w-full">Criar Conta</a>
            </div>

            <div class="text-center mt-4">
                <a href="{{ url('/') }}" class="link link-hover text-sm text-base-content/40">Voltar para o início</a>
            </div>
        </div>
    </div>
</div>
@endsection
