<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin.vue'

defineOptions({ layout: AdminLayout })

defineProps({
  permissions: Object,
})
</script>

<template>
  <Head title="Permissões" />

  <div class="space-y-6">
    <div>
      <h1 class="text-3xl font-bold">Permissões</h1>
    </div>

    <div class="overflow-x-auto">
      <table class="table table-zebra">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Guard</th>
            <th>Funções</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="permission in permissions.data" :key="permission.id">
            <td>
              <Link :href="route('admin.permissions.show', permission.id)" class="link link-hover font-medium">
                {{ permission.name }}
              </Link>
            </td>
            <td class="text-sm font-mono">{{ permission.guard_name }}</td>
            <td>
              <span
                v-for="role in permission.roles"
                :key="role.id"
                class="badge badge-outline badge-sm mr-1"
              >
                {{ role.name }}
              </span>
              <span v-if="!permission.roles?.length" class="text-base-content/50 text-sm">-</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="flex justify-center gap-1" v-if="permissions.links?.length > 3">
      <template v-for="(link, i) in permissions.links" :key="i">
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
