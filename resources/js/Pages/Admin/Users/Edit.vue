<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref } from 'vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  user: Object,
  roles: Array,
  userRoles: Array,
})

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  password: '',
  password_confirmation: '',
  roles: props.userRoles,
})

const showPassword = ref(false)
const showPasswordConfirmation = ref(false)

const submit = () => {
  form.put(route('admin.users.update', props.user.id))
}
</script>

<template>
  <Head title="Editar Usuário" />

  <div class="space-y-6 max-w-2xl">
    <div>
      <h1 class="text-3xl font-bold">Editar Usuário</h1>
      <p class="text-base-content/70 mt-1">{{ user.name }}</p>
    </div>

    <form @submit.prevent="submit" class="space-y-4">
      <div class="form-control">
        <label class="label" for="name">
          <span class="label-text">Nome</span>
        </label>
        <input id="name" v-model="form.name" type="text" class="input input-bordered" :class="{ 'input-error': form.errors.name }" />
        <label v-if="form.errors.name" class="label">
          <span class="label-text-alt text-error">{{ form.errors.name }}</span>
        </label>
      </div>

      <div class="form-control">
        <label class="label" for="email">
          <span class="label-text">Email</span>
        </label>
        <input id="email" v-model="form.email" type="email" class="input input-bordered" :class="{ 'input-error': form.errors.email }" />
        <label v-if="form.errors.email" class="label">
          <span class="label-text-alt text-error">{{ form.errors.email }}</span>
        </label>
      </div>

      <div class="form-control">
        <label class="label" for="password">
          <span class="label-text">Nova Senha</span>
        </label>
        <div class="join">
          <input id="password" v-model="form.password" :type="showPassword ? 'text' : 'password'" class="input input-bordered join-item flex-1" :class="{ 'input-error': form.errors.password }" />
          <button type="button" @click="showPassword = !showPassword" class="btn btn-outline join-item">
            <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
          </button>
        </div>
        <label v-if="form.errors.password" class="label">
          <span class="label-text-alt text-error">{{ form.errors.password }}</span>
        </label>
      </div>

      <div class="form-control">
        <label class="label" for="password_confirmation">
          <span class="label-text">Confirmar Nova Senha</span>
        </label>
        <div class="join">
          <input id="password_confirmation" v-model="form.password_confirmation" :type="showPasswordConfirmation ? 'text' : 'password'" class="input input-bordered join-item flex-1" />
          <button type="button" @click="showPasswordConfirmation = !showPasswordConfirmation" class="btn btn-outline join-item">
            <svg v-if="!showPasswordConfirmation" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
          </button>
        </div>
      </div>

      <div class="form-control">
        <label class="label">
          <span class="label-text">Funções</span>
        </label>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
          <label v-for="role in roles" :key="role.id" class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" :value="role.id" v-model="form.roles" class="checkbox checkbox-sm" />
            <span class="label-text">{{ role.name }}</span>
          </label>
        </div>
      </div>

      <div class="flex gap-2">
        <button type="submit" class="btn btn-primary" :disabled="form.processing">
          Atualizar
        </button>
        <a :href="route('admin.users.index')" class="btn btn-ghost">Cancelar</a>
      </div>
    </form>
  </div>
</template>
