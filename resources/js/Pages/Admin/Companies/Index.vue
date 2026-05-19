<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin.vue'

defineOptions({ layout: AdminLayout })

defineProps({
  companies: Object,
})
</script>

<template>
  <Head title="Empresas" />

  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <h1 class="text-3xl font-bold">Empresas</h1>
      <Link :href="route('admin.companies.create')" class="btn btn-primary">
        Nova Empresa
      </Link>
    </div>

    <div class="overflow-x-auto bg-base-100 rounded-box shadow">
      <table class="table table-zebra">
        <thead>
          <tr>
            <th>Nome</th>
            <th>CNPJ</th>
            <th class="hidden md:table-cell">Telefone</th>
            <th>Plano</th>
            <th>Ativo</th>
            <th class="hidden lg:table-cell">Data</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="company in companies.data" :key="company.id">
            <td class="font-medium">{{ company.nome_fantasia }}</td>
            <td>{{ company.cnpj }}</td>
            <td class="hidden md:table-cell">{{ company.telefone }}</td>
            <td>
              <span class="badge badge-soft badge-info">{{ company.plano }}</span>
            </td>
            <td>
              <span v-if="company.ativo" class="badge badge-soft badge-success">Sim</span>
              <span v-else class="badge badge-soft badge-error">Não</span>
            </td>
            <td class="hidden lg:table-cell">{{ new Date(company.created_at).toLocaleDateString('pt-BR') }}</td>
            <td>
              <Link :href="route('admin.companies.edit', company.id)" class="btn btn-ghost btn-sm">
                Editar
              </Link>
            </td>
          </tr>
          <tr v-if="!companies.data.length">
            <td colspan="7" class="text-center py-8 text-base-content/60">
              Nenhuma empresa cadastrada.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="companies.links && companies.links.length > 3" class="flex justify-center">
      <div class="join">
        <template v-for="link in companies.links" :key="link.label">
          <Link
            v-if="link.url"
            :href="link.url"
            class="join-item btn btn-sm"
            :class="{ 'btn-active': link.active }"
            v-html="link.label"
          />
          <span v-else class="join-item btn btn-sm btn-disabled" v-html="link.label" />
        </template>
      </div>
    </div>
  </div>
</template>
