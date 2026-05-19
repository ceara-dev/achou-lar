<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin.vue'

defineOptions({ layout: AdminLayout })

defineProps({
  audits: Object,
})
</script>

<template>
  <Head title="Auditorias" />

  <div class="space-y-6">
    <div>
      <h1 class="text-3xl font-bold">Auditorias</h1>
    </div>

    <div class="overflow-x-auto">
      <table class="table table-zebra">
        <thead>
          <tr>
            <th>Usuário</th>
            <th>Evento</th>
            <th>Auditable Type</th>
            <th>Auditable ID</th>
            <th>Data</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="audit in audits.data" :key="audit.id">
            <td>{{ audit.user?.name ?? 'Sistema' }}</td>
            <td>
              <span class="badge" :class="{
                'badge-success': audit.event === 'created',
                'badge-warning': audit.event === 'updated',
                'badge-error': audit.event === 'deleted',
                'badge-ghost': !['created','updated','deleted'].includes(audit.event),
              }">
                {{ audit.event }}
              </span>
            </td>
            <td class="text-sm font-mono">{{ audit.auditable_type.split('\\').pop() }}</td>
            <td class="text-sm font-mono">{{ audit.auditable_id }}</td>
            <td>{{ new Date(audit.created_at).toLocaleString('pt-BR') }}</td>
            <td>
              <Link :href="route('admin.audits.show', audit.id)" class="btn btn-xs btn-ghost">Ver</Link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="flex justify-center gap-1" v-if="audits.links?.length > 3">
      <template v-for="(link, i) in audits.links" :key="i">
        <Link
          v-if="link.url"
          :href="link.url"
          class="btn btn-sm"
          :class="{ 'btn-primary': link.active, 'btn-ghost': !link.active }"
          v-html="link.label"
        />
        <span v-else class="btn btn-sm btn-disabled" v-html="link.label" />
      </template>
    </div>
  </div>
</template>
