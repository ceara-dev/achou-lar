<script setup>
import { ref } from 'vue'
import { Link, Head, useForm, usePage } from '@inertiajs/vue3'

const page = usePage()
const user = page.props.auth.user

const userMenuOpen = ref(false)
const mobileMenuOpen = ref(false)

const logoutForm = useForm({})

function submitLogout() {
  logoutForm.post(route('logout'))
}
</script>

<template>
  <Head title="AchouLar - Controle de Acesso Simplificado" />

  <div class="min-h-screen bg-base-200">
    <nav class="navbar bg-base-100/80 backdrop-blur-sm shadow-sm sticky top-0 z-50">
      <div class="flex-1">
        <Link href="/" class="text-2xl font-bold text-primary px-4 tracking-tight">AchouLar</Link>
      </div>

      <div class="hidden sm:flex gap-2 px-4 items-center">
        <template v-if="user">
          <Link :href="route('imovel.create')" class="btn btn-primary btn-sm">Anunciar</Link>
          <div class="dropdown dropdown-end" @click.outside="userMenuOpen = false">
            <label tabindex="0" class="btn btn-ghost btn-circle avatar" @click="userMenuOpen = !userMenuOpen" aria-label="Menu do usuário">
              <div class="w-10 rounded-full bg-primary text-primary-content flex items-center justify-center font-bold text-sm">
                {{ user.name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2) }}
              </div>
            </label>
            <ul tabindex="0" class="mt-3 z-10 p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52" v-if="userMenuOpen">
              <li><Link :href="route('admin.dashboard')">Dashboard</Link></li>
              <li>
                <form @submit.prevent="submitLogout">
                  <button type="submit" :disabled="logoutForm.processing">Sair</button>
                </form>
              </li>
            </ul>
          </div>
        </template>
        <template v-else>
          <Link :href="route('login')" class="btn btn-ghost btn-sm">Entrar</Link>
          <Link :href="route('register')" class="btn btn-primary btn-sm">Criar Conta</Link>
        </template>
      </div>

      <div class="sm:hidden px-2">
        <button class="btn btn-ghost btn-square btn-sm" @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Abrir menu">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </nav>

    <div v-if="mobileMenuOpen" class="sm:hidden bg-base-100 border-t border-base-200 px-4 py-3 space-y-2">
      <template v-if="user">
        <Link :href="route('admin.dashboard')" class="block btn btn-ghost btn-sm w-full justify-start">Dashboard</Link>
        <Link :href="route('imovel.create')" class="block btn btn-primary btn-sm w-full">Anunciar</Link>
        <form @submit.prevent="submitLogout">
          <button type="submit" class="block btn btn-ghost btn-sm w-full justify-start text-left" :disabled="logoutForm.processing">Sair</button>
        </form>
      </template>
      <template v-else>
        <Link :href="route('login')" class="block btn btn-ghost btn-sm w-full justify-start">Entrar</Link>
        <Link :href="route('register')" class="block btn btn-primary btn-sm w-full">Criar Conta</Link>
      </template>
    </div>

    <section class="hero min-h-[calc(100vh-4rem)] bg-gradient-to-b from-base-100 to-base-200 flex items-center">
      <div class="hero-content flex-col lg:flex-row-reverse gap-8 lg:gap-16 max-w-6xl px-4 w-full">
        <div class="mockup-browser bg-base-300 border border-base-300 w-full max-w-lg lg:max-w-xl shrink-0 animate-[fadeIn_0.6s_ease-out]">
          <div class="mockup-browser-toolbar">
            <div class="input">https://achoular.com.br</div>
          </div>
          <div class="flex justify-center px-4 py-16 bg-base-200">
            <span class="text-6xl">🏠</span>
          </div>
        </div>
        <div class="max-w-xl text-center lg:text-left">
          <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight">
            Controle de Acesso
            <span class="text-primary block sm:inline">Simplificado</span>
          </h1>
          <p class="py-6 text-base sm:text-lg text-base-content/70 leading-relaxed">
            Gerencie usuários, funções e permissões do seu sistema de forma intuitiva e segura.
          </p>
          <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-3">
            <Link v-if="!user" :href="route('register')" class="btn btn-primary btn-lg">Começar Agora</Link>
            <Link :href="route('login')" class="btn btn-outline btn-lg">Fazer Login</Link>
          </div>
        </div>
      </div>
    </section>

    <section class="py-12 sm:py-16 px-4 max-w-6xl mx-auto">
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 stats shadow w-full">
        <div class="stat place-items-center py-6">
          <div class="stat-title text-sm sm:text-base">Usuários</div>
          <div class="stat-value text-primary text-3xl sm:text-4xl">2K+</div>
          <div class="stat-desc text-xs sm:text-sm">Usuários ativos</div>
        </div>
        <div class="stat place-items-center py-6">
          <div class="stat-title text-sm sm:text-base">Imóveis</div>
          <div class="stat-value text-secondary text-3xl sm:text-4xl">10K+</div>
          <div class="stat-desc text-xs sm:text-sm">Imóveis cadastrados</div>
        </div>
        <div class="stat place-items-center py-6">
          <div class="stat-title text-sm sm:text-base">Empresas</div>
          <div class="stat-value text-3xl sm:text-4xl">500+</div>
          <div class="stat-desc text-xs sm:text-sm">Empresas parceiras</div>
        </div>
      </div>
    </section>

    <section class="py-12 sm:py-16 px-4 max-w-6xl mx-auto">
      <h2 class="text-2xl sm:text-3xl font-bold text-center mb-8 sm:mb-12">Recursos Poderosos</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <div class="card bg-base-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
          <div class="card-body items-center text-center p-6">
            <div class="text-4xl mb-2 transition-transform duration-300 group-hover:scale-110">👥</div>
            <h3 class="card-title text-base sm:text-lg">Gestão de Usuários</h3>
            <p class="text-sm text-base-content/60">Cadastre e gerencie usuários com facilidade.</p>
          </div>
        </div>
        <div class="card bg-base-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
          <div class="card-body items-center text-center p-6">
            <div class="text-4xl mb-2 transition-transform duration-300 group-hover:scale-110">🔐</div>
            <h3 class="card-title text-base sm:text-lg">Funções e Permissões</h3>
            <p class="text-sm text-base-content/60">Defina funções e permissões personalizadas.</p>
          </div>
        </div>
        <div class="card bg-base-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
          <div class="card-body items-center text-center p-6">
            <div class="text-4xl mb-2 transition-transform duration-300 group-hover:scale-110">📋</div>
            <h3 class="card-title text-base sm:text-lg">Auditoria Completa</h3>
            <p class="text-sm text-base-content/60">Registro detalhado de todas as ações.</p>
          </div>
        </div>
        <div class="card bg-base-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
          <div class="card-body items-center text-center p-6">
            <div class="text-4xl mb-2 transition-transform duration-300 group-hover:scale-110">🛡️</div>
            <h3 class="card-title text-base sm:text-lg">Segurança RBAC</h3>
            <p class="text-sm text-base-content/60">Controle de acesso baseado em funções.</p>
          </div>
        </div>
        <div class="card bg-base-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
          <div class="card-body items-center text-center p-6">
            <div class="text-4xl mb-2 transition-transform duration-300 group-hover:scale-110">🗄️</div>
            <h3 class="card-title text-base sm:text-lg">Banco de Dados</h3>
            <p class="text-sm text-base-content/60">Armazenamento seguro e escalável.</p>
          </div>
        </div>
        <div class="card bg-base-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
          <div class="card-body items-center text-center p-6">
            <div class="text-4xl mb-2 transition-transform duration-300 group-hover:scale-110">🎨</div>
            <h3 class="card-title text-base sm:text-lg">Interface Moderna</h3>
            <p class="text-sm text-base-content/60">Design responsivo e intuitivo.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-16 sm:py-20 bg-primary text-primary-content">
      <div class="max-w-2xl mx-auto text-center px-4">
        <h2 class="text-3xl sm:text-4xl font-bold mb-4">Pronto para começar?</h2>
        <p class="text-base sm:text-lg mb-8 opacity-90">Crie sua conta e descubra como simplificar a gestão de acesso do seu sistema.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-3">
          <Link v-if="!user" :href="route('register')" class="btn btn-accent btn-lg">Criar Conta</Link>
          <Link :href="route('login')" class="btn btn-outline btn-lg text-primary-content border-primary-content hover:bg-primary-content hover:text-primary">Fazer Login</Link>
        </div>
      </div>
    </section>

    <footer class="footer footer-center p-6 sm:p-8 bg-base-300 text-base-content">
      <aside>
        <p class="font-bold text-lg">AchouLar</p>
        <p class="text-sm text-base-content/60">&copy; {{ new Date().getFullYear() }} AchouLar. Todos os direitos reservados.</p>
      </aside>
    </footer>
  </div>
</template>
