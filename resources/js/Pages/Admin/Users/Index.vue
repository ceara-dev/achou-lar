<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  users: Object,
})

const form = useForm({})

const destroy = (id) => {
  if (confirm('Tem certeza que deseja excluir este usuário?')) {
    form.delete(route('admin.users.destroy', id))
  }
}
</script>

<template>
  <Head title="Usuários" />

  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <h1 class="text-3xl font-bold">Usuários</h1>
      <Link :href="route('admin.users.create')" class="btn btn-primary">
        Novo Usuário
      </Link>
    </div>

    <template v-if="$page.props.flash?.success">
      <div role="alert" class="alert alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span>{{ $page.props.flash.success }}</span>
      </div>
    </template>

    <template v-if="$page.props.flash?.error">
      <div role="alert" class="alert alert-error">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span>{{ $page.props.flash.error }}</span>
      </div>
    </template>

    <div class="overflow-x-auto">
      <table class="table table-zebra">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Funções</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users.data" :key="user.id">
            <td class="font-medium">{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>
              <div class="flex flex-wrap gap-1">
                <span
                  v-for="role in user.roles"
                  :key="role.id"
                  class="badge badge-ghost badge-sm"
                >
                  {{ role.name }}
                </span>
              </div>
            </td>
            <td class="flex gap-2">
              <Link :href="route('admin.users.show', user.id)" class="btn btn-xs btn-ghost">Ver</Link>
              <Link :href="route('admin.users.edit', user.id)" class="btn btn-xs btn-ghost">Editar</Link>
              <button @click="destroy(user.id)" class="btn btn-xs btn-ghost text-error">Excluir</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="flex justify-center gap-1" v-if="users.links?.length > 3">
      <template v-for="(link, i) in users.links" :key="i">
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
