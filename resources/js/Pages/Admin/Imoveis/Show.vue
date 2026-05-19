<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin.vue'
import PropostaForm from '@/Components/PropostaForm.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  imovel: Object,
  audits: Array,
  users: Array,
})

const activeTab = ref('dados')
const expandedAudit = ref(null)
const arquivoInput = ref(null)

const contratoForm = useForm({
  acao: 'alugar',
  user_id: null,
  tipo: '',
  valor: '',
  data: '',
  inicio: '',
  prazo: '',
})

const pagForm = useForm({
  contrato_id: null,
  data_vencimento: '',
  data_pagamento: '',
  valor: '',
  atrasado: false,
  agua: '',
  energia: '',
  internet: '',
  observacao: '',
})

function onArquivoChange(e) {
  const file = e.target.files[0]
  if (file) {
    contratoForm.arquivo = file
  }
}

function submitContrato() {
  contratoForm.post(route('admin.imoveis.contratos.store', props.imovel.id), {
    preserveScroll: true,
    onSuccess: () => {
      contratoForm.reset()
      contratoForm.acao = 'alugar'
      if (arquivoInput.value) arquivoInput.value.value = ''
    },
  })
}

function submitPagamento(contratoId) {
  pagForm.post(route('admin.contratos.pagamentos.store', contratoId), {
    preserveScroll: true,
    onSuccess: () => {
      pagForm.reset()
      pagForm.atrasado = false
    },
  })
}

function formatPrice(value) {
  return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value)
}

function formatDate(value) {
  return new Date(value).toLocaleString('pt-BR')
}

function toggleAudit(id) {
  expandedAudit.value = expandedAudit.value === id ? null : id
}

const tabs = [
  { id: 'dados', label: 'Dados' },
  { id: 'fotos', label: 'Fotos' },
  { id: 'documentos', label: 'Documentos' },
  { id: 'contratos', label: 'Contratos' },
  { id: 'propostas', label: 'Propostas' },
  { id: 'historico', label: 'Histórico' },
]
</script>

<template>
  <Head :title="imovel.titulo" />

  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-3xl font-bold">{{ imovel.titulo }}</h1>
        <p class="text-base-content/60 mt-1">ID #{{ imovel.id }}</p>
      </div>
      <Link :href="route('admin.imoveis.index')" class="btn btn-ghost">Voltar</Link>
    </div>

    <div role="tablist" class="tabs tabs-lifted">
      <a
        v-for="tab in tabs"
        :key="tab.id"
        role="tab"
        class="tab"
        :class="{ 'tab-active': activeTab === tab.id }"
        @click.prevent="activeTab = tab.id"
      >
        {{ tab.label }}
      </a>
    </div>

    <div v-if="activeTab === 'dados'">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
          <div class="card bg-base-100 shadow">
            <div class="card-body">
              <h2 class="card-title">Informações do Imóvel</h2>
              <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                  <span class="font-medium">Preço:</span>
                  <p class="text-lg font-bold text-primary">{{ formatPrice(imovel.preco) }}</p>
                </div>
                <div>
                  <span class="font-medium">Status:</span>
                  <p><span class="badge">{{ imovel.status }}</span></p>
                </div>
                <div>
                  <span class="font-medium">Categoria:</span>
                  <p>{{ imovel.categoria?.nome ?? '-' }}</p>
                </div>
                <div>
                  <span class="font-medium">Tipo Negócio:</span>
                  <p>{{ imovel.tipo_negocio?.nome ?? '-' }}</p>
                </div>
                <div>
                  <span class="font-medium">Área:</span>
                  <p>{{ imovel.area ? imovel.area + ' m²' : '-' }}</p>
                </div>
                <div>
                  <span class="font-medium">Quartos / Banheiros / Vagas:</span>
                  <p>{{ imovel.quartos ?? '-' }} / {{ imovel.banheiros ?? '-' }} / {{ imovel.vagas ?? '-' }}</p>
                </div>
                <div>
                  <span class="font-medium">Endereço:</span>
                  <p>{{ imovel.endereco ?? '-' }}</p>
                </div>
                <div>
                  <span class="font-medium">Cidade / Estado:</span>
                  <p>{{ imovel.cidade ?? '-' }} / {{ imovel.estado ?? '-' }}</p>
                </div>
                <div v-if="imovel.data_inicio">
                  <span class="font-medium">Data Início:</span>
                  <p>{{ imovel.data_inicio }}</p>
                </div>
                <div v-if="imovel.data_fim">
                  <span class="font-medium">Data Fim:</span>
                  <p>{{ imovel.data_fim }}</p>
                </div>
                <div class="col-span-2">
                  <span class="font-medium">Proprietário:</span>
                  <p>{{ imovel.user?.name ?? 'N/A' }} ({{ imovel.user?.email ?? '-' }})</p>
                </div>
              </div>
            </div>
          </div>

          <div v-if="imovel.descricao" class="card bg-base-100 shadow">
            <div class="card-body">
              <h2 class="card-title">Descrição</h2>
              <p class="text-sm whitespace-pre-wrap">{{ imovel.descricao }}</p>
            </div>
          </div>
        </div>

        <div class="card bg-base-100 shadow">
          <div class="card-body">
            <h2 class="card-title">Metadados</h2>
            <div class="space-y-1 text-sm">
              <div><span class="font-medium">Criado em:</span> {{ formatDate(imovel.created_at) }}</div>
              <div><span class="font-medium">Atualizado em:</span> {{ formatDate(imovel.updated_at) }}</div>
              <div><span class="font-medium">Visualizações:</span> {{ imovel.views ?? 0 }}</div>
              <div><span class="font-medium">Destaque:</span> {{ imovel.destaque ? 'Sim' : 'Não' }}</div>
              <div><span class="font-medium">Aprovado:</span> {{ imovel.aprovado ? 'Sim' : 'Não' }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="activeTab === 'fotos'">
      <div class="card bg-base-100 shadow">
        <div class="card-body">
          <h2 class="card-title">Fotos do Imóvel</h2>
          <p class="text-sm text-base-content/60 mb-4">{{ imovel.fotos?.length ?? 0 }} foto(s)</p>
          <div v-if="imovel.fotos?.length" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div v-for="foto in imovel.fotos" :key="foto.id" class="aspect-square overflow-hidden rounded-box shadow">
              <img :src="'/storage/' + foto.caminho" class="w-full h-full object-cover" />
            </div>
          </div>
          <p v-else class="text-base-content/50">Nenhuma foto cadastrada.</p>
        </div>
      </div>
    </div>

    <div v-if="activeTab === 'documentos'">
      <div class="card bg-base-100 shadow">
        <div class="card-body">
          <h2 class="card-title">Documentos</h2>
          <p class="text-sm text-base-content/60 mb-4">Documentos vinculados a este imóvel.</p>
          <div v-if="imovel.documentos?.length" class="overflow-x-auto">
            <table class="table table-zebra">
              <thead>
                <tr>
                  <th>Título</th>
                  <th>Descrição</th>
                  <th>Arquivo</th>
                  <th>Data</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="doc in imovel.documentos" :key="doc.id">
                  <td class="font-medium">{{ doc.titulo }}</td>
                  <td class="text-sm text-base-content/70">{{ doc.descricao ?? '-' }}</td>
                  <td>
                    <a :href="'/storage/' + doc.arquivo" target="_blank" class="btn btn-xs btn-ghost">
                      Ver arquivo
                    </a>
                  </td>
                  <td class="text-sm">{{ formatDate(doc.created_at) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <p v-else class="text-base-content/50">Nenhum documento vinculado.</p>
        </div>
      </div>
    </div>

    <div v-if="activeTab === 'contratos'">
      <div class="space-y-6">
        <div v-for="ct in imovel.contratos" :key="ct.id" class="card bg-base-100 shadow">
          <div class="card-body">
            <div class="flex items-start justify-between">
              <div>
                <h3 class="card-title capitalize">{{ ct.acao }} — {{ ct.tipo }}</h3>
                <p class="text-sm text-base-content/60">
                  {{ ct.user?.name ?? 'Sem inquilino' }} |
                  {{ formatPrice(ct.valor) }} |
                  Início {{ ct.inicio }} |
                  {{ ct.prazo }} meses
                  <a v-if="ct.arquivo" :href="'/storage/' + ct.arquivo" target="_blank" class="link link-primary ml-2">Ver contrato</a>
                </p>
              </div>
            </div>

            <div v-if="ct.acao === 'alugar'" class="mt-4 border-t pt-4">
              <h4 class="font-semibold mb-3">Histórico de Pagamentos</h4>

              <div v-if="ct.pagamentos?.length" class="overflow-x-auto mb-4">
                <table class="table table-sm table-zebra">
                  <thead>
                    <tr>
                      <th>Vencimento</th>
                      <th>Pagamento</th>
                      <th>Valor</th>
                      <th>Status</th>
                      <th v-if="ct.pagamentos.some(p => p.agua != null)">Água</th>
                      <th v-if="ct.pagamentos.some(p => p.energia != null)">Energia</th>
                      <th v-if="ct.pagamentos.some(p => p.internet != null)">Internet</th>
                      <th>Obs</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="p in ct.pagamentos" :key="p.id">
                      <td class="text-sm">{{ p.data_vencimento }}</td>
                      <td class="text-sm">{{ p.data_pagamento ?? '-' }}</td>
                      <td class="text-sm font-medium">{{ formatPrice(p.valor) }}</td>
                      <td>
                        <span v-if="p.atrasado" class="badge badge-error badge-sm">Atrasado</span>
                        <span v-else class="badge badge-success badge-sm">Em dia</span>
                      </td>
                      <td v-if="p.agua != null" class="text-sm">{{ formatPrice(p.agua) }}</td>
                      <td v-if="p.energia != null" class="text-sm">{{ formatPrice(p.energia) }}</td>
                      <td v-if="p.internet != null" class="text-sm">{{ formatPrice(p.internet) }}</td>
                      <td class="text-sm text-base-content/60 max-w-[120px] truncate">{{ p.observacao ?? '-' }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <p v-else class="text-sm text-base-content/50 mb-4">Nenhum pagamento registrado.</p>

              <details class="collapse collapse-arrow bg-base-200">
                <summary class="collapse-title text-sm font-medium">Registrar Pagamento</summary>
                <div class="collapse-content">
                  <form @submit.prevent="submitPagamento(ct.id)" class="grid grid-cols-2 gap-3 pt-2">
                    <div class="form-control">
                      <label class="label"><span class="label-text">Vencimento</span></label>
                      <input v-model="pagForm.data_vencimento" type="date" class="input input-bordered input-sm" required />
                    </div>
                    <div class="form-control">
                      <label class="label"><span class="label-text">Data Pagamento</span></label>
                      <input v-model="pagForm.data_pagamento" type="date" class="input input-bordered input-sm" />
                    </div>
                    <div class="form-control">
                      <label class="label"><span class="label-text">Valor</span></label>
                      <input v-model="pagForm.valor" type="number" step="0.01" min="0" class="input input-bordered input-sm" required />
                    </div>
                    <div class="form-control">
                      <label class="label"><span class="label-text">Atrasado</span></label>
                      <select v-model="pagForm.atrasado" class="select select-bordered select-sm">
                        <option :value="false">Não</option>
                        <option :value="true">Sim</option>
                      </select>
                    </div>
                    <div class="form-control">
                      <label class="label"><span class="label-text">Água (opcional)</span></label>
                      <input v-model="pagForm.agua" type="number" step="0.01" min="0" class="input input-bordered input-sm" />
                    </div>
                    <div class="form-control">
                      <label class="label"><span class="label-text">Energia (opcional)</span></label>
                      <input v-model="pagForm.energia" type="number" step="0.01" min="0" class="input input-bordered input-sm" />
                    </div>
                    <div class="form-control">
                      <label class="label"><span class="label-text">Internet (opcional)</span></label>
                      <input v-model="pagForm.internet" type="number" step="0.01" min="0" class="input input-bordered input-sm" />
                    </div>
                    <div class="form-control">
                      <label class="label"><span class="label-text">Observação</span></label>
                      <input v-model="pagForm.observacao" type="text" class="input input-bordered input-sm" />
                    </div>
                    <div class="col-span-2">
                      <button type="submit" class="btn btn-primary btn-sm" :disabled="pagForm.processing">Salvar Pagamento</button>
                    </div>
                  </form>
                </div>
              </details>
            </div>
          </div>
        </div>

        <div class="card bg-base-100 shadow">
          <div class="card-body">
            <h2 class="card-title">Novo Contrato</h2>
            <p class="text-sm text-base-content/60 mb-4">Cadastrar contrato para este imóvel.</p>
            <form @submit.prevent="submitContrato" class="grid grid-cols-2 gap-3 max-w-2xl">
              <div class="form-control">
                <label class="label"><span class="label-text">Ação</span></label>
                <select v-model="contratoForm.acao" class="select select-bordered" required>
                  <option value="alugar">Alugar</option>
                  <option value="comprar">Comprar</option>
                </select>
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Inquilino/Comprador</span></label>
                <select v-model="contratoForm.user_id" class="select select-bordered">
                  <option :value="null">Sem vínculo</option>
                  <option v-for="u in users" :key="u.id" :value="u.id">{{ u.name }} ({{ u.email }})</option>
                </select>
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Tipo</span></label>
                <select v-model="contratoForm.tipo" class="select select-bordered" required>
                  <option value="">Selecione...</option>
                  <option value="compra">Compra</option>
                  <option value="venda">Venda</option>
                  <option value="locacao">Locação</option>
                  <option value="outro">Outro</option>
                </select>
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Valor</span></label>
                <input v-model="contratoForm.valor" type="number" step="0.01" min="0" class="input input-bordered" required />
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Data do Contrato</span></label>
                <input v-model="contratoForm.data" type="date" class="input input-bordered" required />
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Início</span></label>
                <input v-model="contratoForm.inicio" type="date" class="input input-bordered" required />
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Prazo (meses)</span></label>
                <input v-model="contratoForm.prazo" type="number" min="1" class="input input-bordered" required />
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Arquivo (opcional)</span></label>
                <input ref="arquivoInput" type="file" accept=".pdf,.doc,.docx" class="file-input file-input-bordered" @change="onArquivoChange" />
              </div>
              <div class="col-span-2">
                <button type="submit" class="btn btn-primary" :disabled="contratoForm.processing">Salvar Contrato</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div v-if="activeTab === 'propostas'">
      <div class="card bg-base-100 shadow">
        <div class="card-body">
          <h2 class="card-title">Nova Proposta</h2>
          <p class="text-sm text-base-content/60 mb-4">Registrar proposta de compra ou aluguel para este imóvel.</p>
          <div class="max-w-lg">
            <PropostaForm :imovel-id="imovel.id" />
          </div>
        </div>
      </div>
    </div>

    <div v-if="activeTab === 'historico'">
      <div class="card bg-base-100 shadow">
        <div class="card-body">
          <h2 class="card-title">Histórico de Alterações</h2>
          <p class="text-sm text-base-content/60 mb-4">Todas as modificações registradas neste imóvel.</p>

          <div v-if="audits.length" class="overflow-x-auto">
            <table class="table table-zebra">
              <thead>
                <tr>
                  <th>Data / Hora</th>
                  <th>Evento</th>
                  <th>Usuário</th>
                  <th>Campos Alterados</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="audit in audits" :key="audit.id">
                  <td class="text-sm whitespace-nowrap">{{ formatDate(audit.created_at) }}</td>
                  <td>
                    <span class="badge" :class="{
                      'badge-success': audit.event === 'created',
                      'badge-warning': audit.event === 'updated',
                      'badge-error': audit.event === 'deleted',
                      'badge-ghost': !['created','updated','deleted'].includes(audit.event),
                    }">{{ audit.event }}</span>
                  </td>
                  <td class="text-sm">{{ audit.user?.name ?? 'Sistema' }}</td>
                  <td class="text-sm">
                    <template v-if="audit.event === 'created'">
                      <span class="text-success">Criação</span>
                    </template>
                    <template v-else-if="audit.new_values">
                      <span v-for="(val, key) in audit.new_values" :key="key" class="badge badge-ghost badge-sm mr-1 mb-1">{{ key }}</span>
                    </template>
                    <span v-else class="text-base-content/50">-</span>
                  </td>
                  <td>
                    <button class="btn btn-xs btn-ghost" @click="toggleAudit(audit.id)">
                      {{ expandedAudit === audit.id ? 'Fechar' : 'Detalhes' }}
                    </button>
                  </td>
                </tr>
                <tr v-if="expandedAudit" v-for="audit in audits.filter(a => a.id === expandedAudit)" :key="'details-' + audit.id">
                  <td colspan="5" class="p-0">
                    <div class="p-4 bg-base-200">
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div v-if="audit.event !== 'created' && audit.old_values">
                          <h4 class="font-semibold text-sm mb-2 text-error">Valores Antigos</h4>
                          <table class="table table-xs">
                            <thead><tr><th>Campo</th><th>Valor</th></tr></thead>
                            <tbody>
                              <tr v-for="(val, key) in audit.old_values" :key="key">
                                <td class="font-mono">{{ key }}</td>
                                <td>{{ val ?? '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div v-if="audit.event !== 'deleted' && audit.new_values">
                          <h4 class="font-semibold text-sm mb-2 text-success">Novos Valores</h4>
                          <table class="table table-xs">
                            <thead><tr><th>Campo</th><th>Valor</th></tr></thead>
                            <tbody>
                              <tr v-for="(val, key) in audit.new_values" :key="key">
                                <td class="font-mono">{{ key }}</td>
                                <td>{{ val ?? '-' }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <p v-else class="text-base-content/50">Nenhum histórico de alterações registrado.</p>
        </div>
      </div>
    </div>
  </div>
</template>