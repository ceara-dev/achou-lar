<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  company: Object,
})

const form = useForm({
  razao_social: props.company.razao_social,
  nome_fantasia: props.company.nome_fantasia,
  cnpj: props.company.cnpj,
  telefone: props.company.telefone || '',
  email: props.company.email || '',
  plano: props.company.plano,
  ativo: props.company.ativo,
})

function submit() {
  form.put(route('admin.companies.update', props.company.id))
}
</script>

<template>
  <Head title="Editar Empresa" />

  <div class="space-y-6">
    <div>
      <h1 class="text-3xl font-bold">Editar Empresa</h1>
    </div>

    <div class="bg-base-100 rounded-box shadow p-6 max-w-2xl">
      <form @submit.prevent="submit" class="space-y-4">
        <div class="form-control">
          <label class="label"><span class="label-text">Razão Social</span></label>
          <input v-model="form.razao_social" type="text" class="input input-bordered" :class="{ 'input-error': form.errors.razao_social }" />
          <span v-if="form.errors.razao_social" class="text-error text-sm mt-1">{{ form.errors.razao_social }}</span>
        </div>

        <div class="form-control">
          <label class="label"><span class="label-text">Nome Fantasia</span></label>
          <input v-model="form.nome_fantasia" type="text" class="input input-bordered" :class="{ 'input-error': form.errors.nome_fantasia }" />
          <span v-if="form.errors.nome_fantasia" class="text-error text-sm mt-1">{{ form.errors.nome_fantasia }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-control">
            <label class="label"><span class="label-text">CNPJ</span></label>
            <input v-model="form.cnpj" type="text" class="input input-bordered" :class="{ 'input-error': form.errors.cnpj }" />
            <span v-if="form.errors.cnpj" class="text-error text-sm mt-1">{{ form.errors.cnpj }}</span>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">Telefone</span></label>
            <input v-model="form.telefone" type="text" class="input input-bordered" :class="{ 'input-error': form.errors.telefone }" />
            <span v-if="form.errors.telefone" class="text-error text-sm mt-1">{{ form.errors.telefone }}</span>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-control">
            <label class="label"><span class="label-text">E-mail</span></label>
            <input v-model="form.email" type="email" class="input input-bordered" :class="{ 'input-error': form.errors.email }" />
            <span v-if="form.errors.email" class="text-error text-sm mt-1">{{ form.errors.email }}</span>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">Plano</span></label>
            <select v-model="form.plano" class="select select-bordered" :class="{ 'select-error': form.errors.plano }">
              <option value="gratuito">Gratuito</option>
              <option value="starter">Starter</option>
              <option value="pro">Pro</option>
              <option value="business">Business</option>
            </select>
            <span v-if="form.errors.plano" class="text-error text-sm mt-1">{{ form.errors.plano }}</span>
          </div>
        </div>

        <div class="form-control">
          <label class="label cursor-pointer justify-start gap-3">
            <input v-model="form.ativo" type="checkbox" class="checkbox checkbox-primary" />
            <span class="label-text">Ativo</span>
          </label>
        </div>

        <div class="flex gap-3 pt-4">
          <button type="submit" class="btn btn-primary" :disabled="form.processing">
            Salvar
          </button>
          <Link :href="route('admin.companies.index')" class="btn btn-ghost">
            Cancelar
          </Link>
        </div>
      </form>
    </div>
  </div>
</template>
