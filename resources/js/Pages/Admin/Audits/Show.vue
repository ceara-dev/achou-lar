<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin.vue'

defineOptions({ layout: AdminLayout })

defineProps({
  audit: Object,
})

const oldValues = (audit) => {
  if (!audit.old_values) return []
  return Object.entries(audit.old_values)
}

const newValues = (audit) => {
  if (!audit.new_values) return []
  return Object.entries(audit.new_values)
}
</script>

<template>
  <Head title="Detalhes da Auditoria" />

  <div class="space-y-6 max-w-3xl">
    <div class="flex items-center justify-between">
      <h1 class="text-3xl font-bold">Detalhes da Auditoria</h1>
      <Link :href="route('admin.audits.index')" class="btn btn-ghost">
        Voltar
      </Link>
    </div>

    <div class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title">Informações Gerais</h2>
        <div class="space-y-2">
          <div class="flex">
            <span class="font-medium w-40">Evento:</span>
            <span class="badge" :class="{
              'badge-success': audit.event === 'created',
              'badge-warning': audit.event === 'updated',
              'badge-error': audit.event === 'deleted',
              'badge-ghost': !['created','updated','deleted'].includes(audit.event),
            }">{{ audit.event }}</span>
          </div>
          <div class="flex">
            <span class="font-medium w-40">Auditable Type:</span>
            <span class="font-mono text-sm">{{ audit.auditable_type }}</span>
          </div>
          <div class="flex">
            <span class="font-medium w-40">Auditable ID:</span>
            <span>{{ audit.auditable_id }}</span>
          </div>
          <div class="flex">
            <span class="font-medium w-40">Usuário:</span>
            <span>{{ audit.user?.name ?? 'Sistema' }} ({{ audit.user?.email ?? '-' }})</span>
          </div>
          <div class="flex">
            <span class="font-medium w-40">IP:</span>
            <span class="font-mono text-sm">{{ audit.ip_address ?? '-' }}</span>
          </div>
          <div class="flex">
            <span class="font-medium w-40">User Agent:</span>
            <span class="text-sm truncate max-w-md">{{ audit.user_agent ?? '-' }}</span>
          </div>
          <div class="flex">
            <span class="font-medium w-40">Data:</span>
            <span>{{ new Date(audit.created_at).toLocaleString('pt-BR') }}</span>
          </div>
        </div>
      </div>
    </div>

    <div v-if="audit.event !== 'created'" class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title">Valores Antigos</h2>
        <div v-if="oldValues(audit).length" class="overflow-x-auto">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>Campo</th>
                <th>Valor</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="[key, value] in oldValues(audit)" :key="key">
                <td class="font-mono text-sm">{{ key }}</td>
                <td class="text-sm">{{ value ?? '-' }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <p v-else class="text-base-content/50">Nenhum valor antigo registrado.</p>
      </div>
    </div>

    <div v-if="audit.event !== 'deleted'" class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title">Novos Valores</h2>
        <div v-if="newValues(audit).length" class="overflow-x-auto">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>Campo</th>
                <th>Valor</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="[key, value] in newValues(audit)" :key="key">
                <td class="font-mono text-sm">{{ key }}</td>
                <td class="text-sm">{{ value ?? '-' }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <p v-else class="text-base-content/50">Nenhum novo valor registrado.</p>
      </div>
    </div>
  </div>
</template>
