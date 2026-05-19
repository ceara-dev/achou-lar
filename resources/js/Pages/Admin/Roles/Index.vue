<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin.vue'

defineOptions({ layout: AdminLayout })

defineProps({
  roles: Object,
})
</script>

<template>
  <Head title="Funções" />

  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <h1 class="text-3xl font-bold">Funções</h1>
      <Link :href="route('admin.roles.create')" class="btn btn-primary">
        Nova Função
      </Link>
    </div>

    <div class="overflow-x-auto">
      <table class="table table-zebra">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Guard</th>
            <th>Permissões</th>
            <th>Usuários</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="role in roles.data" :key="role.id">
            <td class="font-medium">{{ role.name }}</td>
            <td class="text-sm font-mono">{{ role.guard_name }}</td>
            <td>
              <span class="badge badge-ghost badge-sm">{{ role.permissions_count ?? role.permissions?.length ?? 0 }}</span>
            </td>
            <td>
              <span class="badge badge-ghost badge-sm">{{ role.users_count ?? 0 }}</span>
            </td>
            <td class="flex gap-2">
              <Link :href="route('admin.roles.show', role.id)" class="btn btn-xs btn-ghost">Ver</Link>
              <Link :href="route('admin.roles.edit', role.id)" class="btn btn-xs btn-ghost">Editar</Link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="flex justify-center gap-1" v-if="roles.links?.length > 3">
      <template v-for="(link, i) in roles.links" :key="i">
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
