<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin.vue'

defineOptions({ layout: AdminLayout })

defineProps({
  permission: Object,
})
</script>

<template>
  <Head :title="permission.name" />

  <div class="space-y-6 max-w-2xl">
    <div class="flex items-center justify-between">
      <h1 class="text-3xl font-bold">{{ permission.name }}</h1>
      <div class="flex gap-2">
        <Link :href="route('admin.permissions.index')" class="btn btn-ghost">
          Voltar
        </Link>
      </div>
    </div>

    <div class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title">Informações da Permissão</h2>
        <div class="space-y-2">
          <div class="flex">
            <span class="font-medium w-32">Nome:</span>
            <span>{{ permission.name }}</span>
          </div>
          <div class="flex">
            <span class="font-medium w-32">Guard:</span>
            <span class="font-mono text-sm">{{ permission.guard_name }}</span>
          </div>
          <div class="flex">
            <span class="font-medium w-32">Criado em:</span>
            <span>{{ new Date(permission.created_at).toLocaleDateString('pt-BR') }}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title">Funções com esta Permissão</h2>
        <div v-if="permission.roles?.length" class="flex flex-wrap gap-2">
          <span
            v-for="role in permission.roles"
            :key="role.id"
            class="badge badge-lg"
          >
            {{ role.name }}
          </span>
        </div>
        <p v-else class="text-base-content/50">Nenhuma função possui esta permissão.</p>
      </div>
    </div>
  </div>
</template>
