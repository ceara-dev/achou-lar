<script setup>
import { ref, onMounted } from 'vue'
import { Link, Head, useForm } from '@inertiajs/vue3'

const showPassword = ref(false)
const emailInput = ref(null)

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

function submit() {
  form.post(route('login'))
}

onMounted(() => {
  emailInput.value?.focus()
})
</script>

<template>
  <Head title="Login - AchouLar" />

  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-base-200 to-base-300 px-4 py-8">
    <div class="card w-full max-w-md bg-base-100 shadow-xl">
      <div class="card-body p-6 sm:p-8">
        <div class="text-center mb-6">
          <Link href="/" class="text-3xl font-bold text-primary">AchouLar</Link>
          <p class="text-base-content/60 mt-2 text-sm sm:text-base">Faça login para continuar</p>
        </div>

        <form @submit.prevent="submit" novalidate>
          <div class="form-control mb-4">
            <label class="label" for="email">
              <span class="label-text">E-mail</span>
            </label>
            <input
              ref="emailInput"
              id="email"
              v-model="form.email"
              type="email"
              class="input input-bordered w-full"
              :class="{ 'input-error': form.errors.email }"
              autocomplete="email"
              autofocus
            />
            <label class="label" v-if="form.errors.email">
              <span class="label-text-alt text-error flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ form.errors.email }}
              </span>
            </label>
          </div>

          <div class="form-control mb-2">
            <label class="label" for="password">
              <span class="label-text">Senha</span>
            </label>
            <div class="join w-full">
              <input
                id="password"
                v-model="form.password"
                :type="showPassword ? 'text' : 'password'"
                class="input input-bordered join-item w-full"
                :class="{ 'input-error': form.errors.password }"
                autocomplete="current-password"
              />
              <button
                type="button"
                class="btn btn-square join-item"
                :aria-label="showPassword ? 'Esconder senha' : 'Mostrar senha'"
                @click="showPassword = !showPassword"
                tabindex="-1"
              >
                <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
              </button>
            </div>
            <label class="label" v-if="form.errors.password">
              <span class="label-text-alt text-error flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ form.errors.password }}
              </span>
            </label>
          </div>

          <div class="form-control mb-6">
            <label class="label cursor-pointer justify-start gap-2">
              <input type="checkbox" v-model="form.remember" class="checkbox checkbox-primary" />
              <span class="label-text">Lembrar de mim</span>
            </label>
          </div>

          <button type="submit" class="btn btn-primary w-full" :disabled="form.processing">
            <span v-if="form.processing" class="loading loading-spinner loading-sm"></span>
            <span v-else>Entrar</span>
          </button>
        </form>

        <div class="divider my-6">ou</div>

        <div class="flex flex-col items-center gap-2">
          <Link :href="route('register')" class="link link-primary text-sm hover:link-hover">Criar Conta</Link>
          <Link href="/" class="link link-secondary text-sm hover:link-hover">Voltar para o início</Link>
        </div>
      </div>
    </div>
  </div>
</template>
