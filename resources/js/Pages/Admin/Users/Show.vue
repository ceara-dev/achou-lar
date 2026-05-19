<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({ layout: AdminLayout })

defineProps({
  user: Object,
})
</script>

<template>
  <Head :title="user.name" />

  <div class="space-y-6 max-w-2xl">
    <div class="flex items-center justify-between">
      <h1 class="text-3xl font-bold">{{ user.name }}</h1>
      <div class="flex gap-2">
        <Link :href="route('admin.users.edit', user.id)" class="btn btn-primary">
          Editar
        </Link>
        <Link :href="route('admin.users.index')" class="btn btn-ghost">
          Voltar
        </Link>
      </div>
    </div>

    <div class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title">Informações do Usuário</h2>
        <div class="space-y-2">
          <div class="flex">
            <span class="font-medium w-32">Nome:</span>
            <span>{{ user.name }}</span>
          </div>
          <div class="flex">
            <span class="font-medium w-32">Email:</span>
            <span>{{ user.email }}</span>
          </div>
          <div class="flex">
            <span class="font-medium w-32">Criado em:</span>
            <span>{{ new Date(user.created_at).toLocaleDateString('pt-BR') }}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title">Funções</h2>
        <div class="flex flex-wrap gap-2">
          <span
            v-for="role in user.roles"
            :key="role.id"
            class="badge badge-primary badge-lg"
          >
            {{ role.name }}
          </span>
          <span v-if="!user.roles?.length" class="text-base-content/50">Nenhuma função atribuída.</span>
        </div>
      </div>
    </div>

    <div class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title">Permissões</h2>
        <div class="flex flex-wrap gap-2">
          <span
            v-for="permission in user.permissions"
            :key="permission.id"
            class="badge badge-ghost badge-sm"
          >
            {{ permission.name }}
          </span>
          <span v-if="!user.permissions?.length" class="text-base-content/50">Nenhuma permissão direta.</span>
        </div>
      </div>
    </div>
  </div>
</template>
