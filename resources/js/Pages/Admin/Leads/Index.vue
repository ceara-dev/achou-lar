<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin.vue'

defineOptions({ layout: AdminLayout })

defineProps({
  leads: Object,
})
</script>

<template>
  <Head title="Leads Recebidos" />

  <div class="space-y-6">
    <div>
      <h1 class="text-3xl font-bold">Leads Recebidos</h1>
    </div>

    <div class="overflow-x-auto bg-base-100 rounded-box shadow">
      <table class="table">
        <thead>
          <tr>
            <th>Interessado</th>
            <th class="hidden md:table-cell">E-mail</th>
            <th class="hidden md:table-cell">Telefone</th>
            <th>Imóvel</th>
            <th class="hidden lg:table-cell">Data</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="lead in leads.data"
            :key="lead.id"
            :class="{
              'font-bold bg-base-200': !lead.lido,
            }"
          >
            <td>
              <div class="flex items-center gap-2">
                <span v-if="!lead.lido" class="w-2 h-2 bg-error rounded-full shrink-0" />
                <span>{{ lead.nome }}</span>
              </div>
            </td>
            <td class="hidden md:table-cell">{{ lead.email }}</td>
            <td class="hidden md:table-cell">{{ lead.telefone }}</td>
            <td>
              <Link
                v-if="lead.imovel"
                :href="route('admin.leads.show', lead.id)"
                class="link link-primary"
              >
                {{ lead.imovel.titulo }}
              </Link>
              <span v-else class="text-base-content/50">Imóvel removido</span>
            </td>
            <td class="hidden lg:table-cell">{{ new Date(lead.created_at).toLocaleDateString('pt-BR') }}</td>
            <td>
              <div class="flex gap-1">
                <Link :href="route('admin.leads.show', lead.id)" class="btn btn-ghost btn-sm">
                  Ver
                </Link>
                <Link
                  :href="route('admin.leads.unread', lead.id)"
                  method="put"
                  as="button"
                  class="btn btn-ghost btn-sm"
                >
                  Marcar não lido
                </Link>
              </div>
            </td>
          </tr>
          <tr v-if="!leads.data.length">
            <td colspan="6" class="text-center py-8 text-base-content/60">
              Nenhum lead recebido.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="leads.links && leads.links.length > 3" class="flex justify-center">
      <div class="join">
        <template v-for="link in leads.links" :key="link.label">
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
