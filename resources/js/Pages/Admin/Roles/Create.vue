<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  permissions: Object,
})

const form = useForm({
  name: '',
  permissions: [],
})

const submit = () => {
  form.post(route('admin.roles.store'))
}

const groups = Object.entries(props.permissions)
</script>

<template>
  <Head title="Criar Função" />

  <div class="space-y-6 max-w-2xl">
    <div class="flex items-center justify-between">
      <h1 class="text-3xl font-bold">Criar Função</h1>
      <Link :href="route('admin.roles.index')" class="btn btn-ghost">Voltar</Link>
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

      <div v-for="[group, perms] in groups" :key="group" class="card bg-base-100 shadow">
        <div class="card-body">
          <h3 class="card-title text-base capitalize">{{ group }}</h3>
          <div class="flex flex-wrap gap-3">
            <label v-for="permission in perms" :key="permission.id" class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" :value="permission.id" v-model="form.permissions" class="checkbox checkbox-sm" />
              <span class="label-text">{{ permission.name }}</span>
            </label>
          </div>
        </div>
      </div>
      <label v-if="form.errors.permissions" class="label">
        <span class="label-text-alt text-error">{{ form.errors.permissions }}</span>
      </label>

      <div class="flex gap-2">
        <button type="submit" class="btn btn-primary" :disabled="form.processing">
          Salvar
        </button>
        <Link :href="route('admin.roles.index')" class="btn btn-ghost">Cancelar</Link>
      </div>
    </form>
  </div>
</template>
