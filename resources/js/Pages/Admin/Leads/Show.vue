<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin.vue'

defineOptions({ layout: AdminLayout })

defineProps({
  lead: Object,
})
</script>

<template>
  <Head title="Lead - {{ lead.nome }}" />

  <div class="space-y-6">
    <div>
      <h1 class="text-3xl font-bold">Lead</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div class="lg:col-span-2 space-y-6">
        <div class="bg-base-100 rounded-box shadow p-6">
          <h2 class="text-lg font-semibold mb-4">Dados de Contato</h2>

          <div class="space-y-3">
            <div>
              <span class="text-sm text-base-content/60">Nome</span>
              <p class="font-medium">{{ lead.nome }}</p>
            </div>
            <div>
              <span class="text-sm text-base-content/60">E-mail</span>
              <p class="font-medium">{{ lead.email }}</p>
            </div>
            <div>
              <span class="text-sm text-base-content/60">Telefone</span>
              <p class="font-medium">{{ lead.telefone }}</p>
            </div>
            <div>
              <span class="text-sm text-base-content/60">Recebido em</span>
              <p class="font-medium">{{ new Date(lead.created_at).toLocaleString('pt-BR') }}</p>
            </div>
          </div>

          <div v-if="lead.mensagem" class="mt-6">
            <span class="text-sm text-base-content/60">Mensagem</span>
            <p class="mt-1 whitespace-pre-wrap">{{ lead.mensagem }}</p>
          </div>
        </div>
      </div>

      <div class="space-y-6">
        <div v-if="lead.imovel" class="bg-base-100 rounded-box shadow p-6">
          <h2 class="text-lg font-semibold mb-4">Imóvel</h2>

          <div class="space-y-3">
            <div>
              <span class="text-sm text-base-content/60">Título</span>
              <p class="font-medium">{{ lead.imovel.titulo }}</p>
            </div>
            <div>
              <span class="text-sm text-base-content/60">Endereço</span>
              <p class="font-medium">{{ lead.imovel.endereco }}{{ lead.imovel.bairro ? ', ' + lead.imovel.bairro : '' }}</p>
            </div>
            <div v-if="lead.imovel.categoria">
              <span class="text-sm text-base-content/60">Categoria</span>
              <p class="font-medium">{{ lead.imovel.categoria.nome }}</p>
            </div>
            <div v-if="lead.imovel.tipo_negocio">
              <span class="text-sm text-base-content/60">Tipo de Negócio</span>
              <p class="font-medium">{{ lead.imovel.tipo_negocio.nome }}</p>
            </div>
          </div>
        </div>

        <div class="bg-base-100 rounded-box shadow p-6">
          <Link
            :href="route('admin.leads.unread', lead.id)"
            method="put"
            as="button"
            class="btn btn-warning w-full"
          >
            Marcar como não lido
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>
