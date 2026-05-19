@extends('layouts.guest')

@section('title', config('app.name') . ' - Gerencie com Segurança')

@section('content')
    {{-- Navbar --}}
    <div class="navbar bg-base-100 shadow-sm sticky top-0 z-50">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                    <li><a href="#">Comprar</a></li>
                    <li><a href="#">Alugar</a></li>
                    <li><a href="#">Terrenos</a></li>
                    <li><a href="{{ route('login') }}">Anunciar</a></li>
                </ul>
            </div>
            <a href="{{ url('/') }}" class="btn btn-ghost text-xl font-bold">{{ config('app.name') }}</a>
        </div>

        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1 gap-1">
                <li><a href="#" class="btn btn-ghost btn-sm">Comprar</a></li>
                <li><a href="#" class="btn btn-ghost btn-sm">Alugar</a></li>
                <li><a href="#" class="btn btn-ghost btn-sm">Terrenos</a></li>
            </ul>
        </div>

        <div class="navbar-end gap-2">
            @auth
                <a href="{{ route('imovel.create') }}" class="btn btn-primary btn-sm">Anunciar</a>
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-sm">
                        {{ auth()->user()->name }}
                    </div>
                    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.users.index') }}">Meus Imóveis</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Sair</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Entrar</a>
                <a href="{{ route('imovel.create') }}" class="btn btn-primary btn-sm">Anunciar</a>
            @endauth
        </div>
    </div>

    {{-- Hero Section --}}
    <section class="hero bg-base-100 min-h-[80vh]">
        <div class="hero-content flex-col lg:flex-row-reverse gap-12 max-w-6xl">
            <div class="mockup-browser bg-base-300 border border-base-300 w-full lg:max-w-xl">
                <div class="mockup-browser-toolbar">
                    <div class="input">https://achoular.app</div>
                </div>
                <div class="bg-base-200 p-6 flex justify-center">
                    <div class="stats shadow">
                        <div class="stat">
                            <div class="stat-title">Usuários</div>
                            <div class="stat-value text-primary">1.2K+</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Funções</div>
                            <div class="stat-value text-secondary">12</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Auditorias</div>
                            <div class="stat-value text-accent">5.6K</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-lg">
                <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight">
                    Controle de Acesso
                    <span class="text-primary">Simplificado</span>
                </h1>
                <p class="py-6 text-base-content/70 text-lg leading-relaxed">
                    Gerencie usuários, funções e permissões com facilidade. 
                    Auditoria completa de todas as ações do sistema com interface 
                    moderna e responsiva.
                </p>
                <div class="flex gap-3">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg">Ir para o Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Começar Agora</a>
                        <a href="{{ route('login') }}" class="btn btn-outline btn-lg">Fazer Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="py-20 px-4 max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold mb-4">Tudo que você precisa para gerenciar seu sistema</h2>
            <p class="text-base-content/60 text-lg max-w-2xl mx-auto">
                Ferramentas completas para controle de acesso e monitoramento de atividades.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="card-body items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="card-title">Gestão de Usuários</h3>
                    <p class="text-base-content/60">Cadastre, edite e gerencie todos os usuários do sistema com atribuição de funções.</p>
                </div>
            </div>

            <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="card-body items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-secondary/10 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="card-title">Funções e Permissões</h3>
                    <p class="text-base-content/60">Crie funções personalizadas e atribua permissões específicas para cada uma.</p>
                </div>
            </div>

            <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="card-body items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-accent/10 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h3 class="card-title">Auditoria Completa</h3>
                    <p class="text-base-content/60">Registre e visualize todas as alterações feitas no sistema com detalhes completos.</p>
                </div>
            </div>

            <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="card-body items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-info/10 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-info" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="card-title">Segurança RBAC</h3>
                    <p class="text-base-content/60">Controle de acesso baseado em funções (RBAC) com proteção por middleware.</p>
                </div>
            </div>

            <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="card-body items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-success/10 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                    </div>
                    <h3 class="card-title">Banco de Dados</h3>
                    <p class="text-base-content/60">Migrações e seeders prontos para começar a usar imediatamente.</p>
                </div>
            </div>

            <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="card-body items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-warning/10 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="card-title">Interface Moderna</h3>
                    <p class="text-base-content/60">Design responsivo com DaisyUI, tema claro/escuro e componentes acessíveis.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="bg-primary text-primary-content py-20">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-3xl lg:text-4xl font-bold mb-4">Pronto para começar?</h2>
            <p class="text-lg mb-8 opacity-90 max-w-2xl mx-auto">
                Crie sua conta agora e tenha acesso a todas as funcionalidades de gerenciamento.
            </p>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn btn-lg bg-base-100 text-base-content border-none hover:bg-base-200">Ir para o Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-lg bg-base-100 text-base-content border-none hover:bg-base-200">Criar Conta Gratuita</a>
            @endauth
        </div>
    </section>

    {{-- Footer extra --}}
    <div class="bg-base-100 py-8">
        <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="font-bold text-lg">{{ config('app.name') }}</div>
            <div class="text-sm text-base-content/60">
                Feito com Laravel, DaisyUI e Tailwind CSS
            </div>
        </div>
    </div>
@endsection
