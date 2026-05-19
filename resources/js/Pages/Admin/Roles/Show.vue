<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin.vue'

defineOptions({ layout: AdminLayout })

defineProps({
  role: Object,
})
</script>

<template>
  <Head :title="role.name" />

  <div class="space-y-6 max-w-2xl">
    <div class="flex items-center justify-between">
      <h1 class="text-3xl font-bold">{{ role.name }}</h1>
      <div class="flex gap-2">
        <Link :href="route('admin.roles.edit', role.id)" class="btn btn-primary">
          Editar
        </Link>
        <Link :href="route('admin.roles.index')" class="btn btn-ghost">
          Voltar
        </Link>
      </div>
    </div>

    <div class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title">Informações da Função</h2>
        <div class="space-y-2">
          <div class="flex">
            <span class="font-medium w-32">Nome:</span>
            <span>{{ role.name }}</span>
          </div>
          <div class="flex">
            <span class="font-medium w-32">Guard:</span>
            <span class="font-mono text-sm">{{ role.guard_name }}</span>
          </div>
          <div class="flex">
            <span class="font-medium w-32">Criado em:</span>
            <span>{{ new Date(role.created_at).toLocaleDateString('pt-BR') }}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title">Permissões</h2>
        <div class="flex flex-wrap gap-2">
          <span
            v-for="permission in role.permissions"
            :key="permission.id"
            class="badge badge-ghost badge-sm"
          >
            {{ permission.name }}
          </span>
          <span v-if="!role.permissions?.length" class="text-base-content/50">Nenhuma permissão atribuída.</span>
        </div>
      </div>
    </div>
  </div>
</template>
