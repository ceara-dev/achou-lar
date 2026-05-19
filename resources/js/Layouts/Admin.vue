<script setup>
import { ref } from 'vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'

const drawerOpen = ref(false)

const page = usePage()
const user = page.props.auth.user
const flash = page.props.flash

const initials = user?.name
  ?.split(' ')
  ?.map(n => n[0])
  ?.join('')
  ?.toUpperCase()
  ?.slice(0, 2)

const logoutForm = useForm({})

function submitLogout() {
  logoutForm.post(route('logout'))
}
</script>

<template>
  <div class="min-h-screen bg-base-200 drawer lg:drawer-open">
    <input id="admin-drawer" type="checkbox" class="drawer-toggle" v-model="drawerOpen" />

    <div class="drawer-content flex flex-col">
      <div class="navbar bg-base-100 lg:hidden shadow-sm">
        <div class="flex-none">
          <label for="admin-drawer" class="btn btn-square btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </label>
        </div>
        <div class="flex-1">
          <Link :href="route('admin.dashboard')" class="text-lg font-semibold">{{ $page.props.appName ?? 'AchouLar' }}</Link>
        </div>
      </div>

      <div v-if="flash.success" class="alert alert-success rounded-none">
        <span>{{ flash.success }}</span>
      </div>
      <div v-if="flash.error" class="alert alert-error rounded-none">
        <span>{{ flash.error }}</span>
      </div>

      <main class="flex-1 p-4 lg:p-8">
        <slot />
      </main>
    </div>

    <div class="drawer-side z-40">
      <label for="admin-drawer" class="drawer-overlay"></label>

      <aside class="flex flex-col min-h-full w-80 bg-base-100 border-r border-base-300">
        <div class="p-6">
          <Link :href="route('home')" class="text-2xl font-bold text-primary">AchouLar</Link>
        </div>

        <ul class="menu px-4 flex-1">
          <li>
            <Link :href="route('admin.dashboard')">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
              Dashboard
            </Link>
          </li>

          <li class="menu-title mt-4">
            <span>Imóveis</span>
          </li>
          <li>
            <Link :href="route('admin.imoveis.index')">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
              Meus Imóveis
            </Link>
          </li>
          <li>
            <Link :href="route('imovel.create')">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
              Novo Imóvel
            </Link>
          </li>
          <li>
            <Link :href="route('admin.leads.index')">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
              Leads Recebidos
            </Link>
          </li>

          <li class="menu-title mt-4" v-if="user?.permissions?.length">
            <span>Administração</span>
          </li>
          <li v-if="user?.permissions?.includes('view companies')">
            <Link :href="route('admin.companies.index')">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
              Empresas
            </Link>
          </li>
          <li v-if="user?.permissions?.includes('view users')">
            <Link :href="route('admin.users.index')">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
              Usuários
            </Link>
          </li>
          <li v-if="user?.permissions?.includes('view roles')">
            <Link :href="route('admin.roles.index')">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
              Funções
            </Link>
          </li>
          <li v-if="user?.permissions?.includes('view permissions')">
            <Link :href="route('admin.permissions.index')">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
              Permissões
            </Link>
          </li>
          <li v-if="user?.permissions?.includes('view audits')">
            <Link :href="route('admin.audits.index')">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
              Auditoria
            </Link>
          </li>
        </ul>

        <div class="border-t border-base-300 p-4">
          <div class="flex items-center gap-3 mb-3">
            <div class="avatar placeholder">
              <div class="bg-primary text-primary-content rounded-full w-10">
                <span>{{ initials }}</span>
              </div>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-semibold truncate">{{ user?.name }}</p>
              <p class="text-xs text-base-content/60 truncate">{{ user?.email }}</p>
            </div>
          </div>
          <form @submit.prevent="submitLogout">
            <button type="submit" class="btn btn-ghost btn-sm w-full justify-start" :disabled="logoutForm.processing">
              Sair
            </button>
          </form>
        </div>
      </aside>
    </div>
  </div>
</template>
