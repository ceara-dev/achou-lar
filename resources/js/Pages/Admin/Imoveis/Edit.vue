<script setup>
import { ref, computed } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  imovel: Object,
  categorias: Array,
  tipos: Array,
})

function parseEndereco(endereco) {
  if (!endereco) return { endereco: '', numero: '' }
  const ultimaVirgula = endereco.lastIndexOf(', ')
  if (ultimaVirgula === -1) return { endereco, numero: '' }
  const possivelNumero = endereco.slice(ultimaVirgula + 2).trim()
  return /^\d+/.test(possivelNumero)
    ? { endereco: endereco.slice(0, ultimaVirgula), numero: possivelNumero }
    : { endereco, numero: '' }
}

const enderecoParsed = parseEndereco(props.imovel.endereco ?? '')

const form = useForm({
  categoria_id: props.imovel.categoria_id ?? '',
  tipo_negocio_id: props.imovel.tipo_negocio_id ?? '',
  titulo: props.imovel.titulo ?? '',
  descricao: props.imovel.descricao ?? '',
  regras: props.imovel.regras ?? '',
  preco: props.imovel.preco ?? '',
  valor_condominio: props.imovel.valor_condominio ?? '',
  iptu: props.imovel.iptu ?? '',
  inclui_agua: props.imovel.inclui_agua ?? false,
  inclui_energia: props.imovel.inclui_energia ?? false,
  inclui_internet: props.imovel.inclui_internet ?? false,
  area: props.imovel.area ?? '',
  quartos: props.imovel.quartos ?? '',
  banheiros: props.imovel.banheiros ?? '',
  cozinhas: props.imovel.cozinhas ?? '',
  vagas: props.imovel.vagas ?? '',
  tipo_residencia: props.imovel.tipo_residencia ?? '',
  endereco: enderecoParsed.endereco,
  numero: enderecoParsed.numero,
  bairro: props.imovel.bairro ?? '',
  cidade: props.imovel.cidade ?? '',
  estado: props.imovel.estado ?? '',
  cep: props.imovel.cep ?? '',
  latitude: props.imovel.latitude ?? '',
  longitude: props.imovel.longitude ?? '',
  data_inicio: props.imovel.data_inicio ?? '',
  data_fim: props.imovel.data_fim ?? '',
  fotos: [],
})

const fotosArray = ref([])
const fotoInput = ref(null)

const temporadaTipo = computed(() => {
  const tipo = props.tipos.find(t => t.id == form.tipo_negocio_id)
  return tipo?.slug === 'temporada'
})

function onTipoChange() {
  // just trigger computed
}

function handleFileInput(e) {
  for (const file of e.target.files) {
    fotosArray.value.push({ file, url: URL.createObjectURL(file) })
  }
  e.target.value = ''
}

function removeFoto(index) {
  URL.revokeObjectURL(fotosArray.value[index].url)
  fotosArray.value.splice(index, 1)
}

function submit() {
  if (fotosArray.value.length) {
    form.fotos = fotosArray.value.map(f => f.file)
  }
  form.put(route('admin.imoveis.update', props.imovel.id), {
    forceFormData: true,
    preserveScroll: true,
    onSuccess: () => {
      fotosArray.value.forEach(f => URL.revokeObjectURL(f.url))
      fotosArray.value = []
    },
  })
}
</script>

<template>
  <Head :title="'Editar: ' + imovel.titulo" />

  <div class="space-y-6 max-w-3xl">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-3xl font-bold">Editar Imóvel</h1>
        <p class="text-base-content/60 mt-1">ID #{{ imovel.id }} — {{ imovel.titulo }}</p>
      </div>
      <Link :href="route('admin.imoveis.index')" class="btn btn-ghost">Voltar</Link>
    </div>

    <form @submit.prevent="submit" class="space-y-6">
      <div class="card bg-base-100 shadow">
        <div class="card-body">
          <h2 class="card-title">Informações Básicas</h2>
          <div class="grid grid-cols-2 gap-4">
            <div class="form-control col-span-2">
              <label class="label"><span class="label-text">Título</span></label>
              <input v-model="form.titulo" type="text" class="input input-bordered" :class="{ 'input-error': form.errors.titulo }" required />
              <label v-if="form.errors.titulo" class="label"><span class="label-text-alt text-error">{{ form.errors.titulo }}</span></label>
            </div>

            <div class="form-control col-span-2">
              <label class="label"><span class="label-text">Descrição</span></label>
              <textarea v-model="form.descricao" class="textarea textarea-bordered" rows="4" :class="{ 'textarea-error': form.errors.descricao }" required></textarea>
              <label v-if="form.errors.descricao" class="label"><span class="label-text-alt text-error">{{ form.errors.descricao }}</span></label>
            </div>

            <div class="form-control">
              <label class="label"><span class="label-text">Categoria</span></label>
              <select v-model="form.categoria_id" class="select select-bordered" required>
                <option value="">Selecione...</option>
                <option v-for="cat in categorias" :key="cat.id" :value="cat.id">{{ cat.nome }}</option>
              </select>
            </div>

            <div class="form-control">
              <label class="label"><span class="label-text">Tipo de Negócio</span></label>
              <select v-model="form.tipo_negocio_id" class="select select-bordered" @change="onTipoChange" required>
                <option value="">Selecione...</option>
                <option v-for="t in tipos" :key="t.id" :value="t.id">{{ t.nome }}</option>
              </select>
            </div>

            <div class="form-control">
              <label class="label"><span class="label-text">Preço</span></label>
              <input v-model="form.preco" type="number" step="0.01" min="0" class="input input-bordered" required />
            </div>

            <div class="form-control">
              <label class="label"><span class="label-text">Tipo Residência</span></label>
              <select v-model="form.tipo_residencia" class="select select-bordered">
                <option value="">Selecione...</option>
                <option value="residencial">Residencial</option>
                <option value="comercial">Comercial</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="card bg-base-100 shadow">
        <div class="card-body">
          <h2 class="card-title">Detalhes do Imóvel</h2>
          <div class="grid grid-cols-3 gap-4">
            <div class="form-control">
              <label class="label"><span class="label-text">Área (m²)</span></label>
              <input v-model="form.area" type="number" step="0.01" min="0" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Quartos</span></label>
              <input v-model="form.quartos" type="number" min="0" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Banheiros</span></label>
              <input v-model="form.banheiros" type="number" min="0" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Cozinhas</span></label>
              <input v-model="form.cozinhas" type="number" min="0" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Vagas</span></label>
              <input v-model="form.vagas" type="number" min="0" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Valor Condomínio</span></label>
              <input v-model="form.valor_condominio" type="number" step="0.01" min="0" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">IPTU</span></label>
              <input v-model="form.iptu" type="number" step="0.01" min="0" class="input input-bordered" />
            </div>
            <div class="form-control col-span-3">
              <label class="label"><span class="label-text">Regras</span></label>
              <textarea v-model="form.regras" class="textarea textarea-bordered" rows="2"></textarea>
            </div>
          </div>

          <div class="flex flex-wrap gap-4 mt-2">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" v-model="form.inclui_agua" class="checkbox checkbox-sm" />
              <span class="label-text">Inclui Água</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" v-model="form.inclui_energia" class="checkbox checkbox-sm" />
              <span class="label-text">Inclui Energia</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" v-model="form.inclui_internet" class="checkbox checkbox-sm" />
              <span class="label-text">Inclui Internet</span>
            </label>
          </div>
        </div>
      </div>

      <div v-if="temporadaTipo" class="card bg-base-100 shadow border-l-4 border-accent">
        <div class="card-body">
          <h2 class="card-title">Temporada</h2>
          <div class="grid grid-cols-2 gap-4">
            <div class="form-control">
              <label class="label"><span class="label-text">Data Início</span></label>
              <input v-model="form.data_inicio" type="date" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Data Fim</span></label>
              <input v-model="form.data_fim" type="date" class="input input-bordered" />
            </div>
          </div>
        </div>
      </div>

      <div class="card bg-base-100 shadow">
        <div class="card-body">
          <h2 class="card-title">Endereço</h2>
          <div class="grid grid-cols-3 gap-4">
            <div class="form-control col-span-2">
              <label class="label"><span class="label-text">Endereço</span></label>
              <input v-model="form.endereco" type="text" class="input input-bordered" required />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Número</span></label>
              <input v-model="form.numero" type="text" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Bairro</span></label>
              <input v-model="form.bairro" type="text" class="input input-bordered" />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">CEP</span></label>
              <input v-model="form.cep" type="text" class="input input-bordered" maxlength="9" />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Cidade</span></label>
              <input v-model="form.cidade" type="text" class="input input-bordered" required />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Estado</span></label>
              <input v-model="form.estado" type="text" class="input input-bordered" maxlength="2" required />
            </div>
          </div>
        </div>
      </div>

      <div class="card bg-base-100 shadow">
        <div class="card-body">
          <h2 class="card-title">Fotos</h2>

          <div v-if="imovel.fotos?.length" class="mb-4">
            <p class="text-sm text-base-content/60 mb-2">Fotos atuais ({{ imovel.fotos.length }})</p>
            <div class="flex flex-wrap gap-2">
              <div v-for="foto in imovel.fotos" :key="foto.id" class="w-24 h-24 overflow-hidden rounded-box shadow">
                <img :src="'/storage/' + foto.caminho" class="w-full h-full object-cover" />
              </div>
            </div>
          </div>

          <div class="form-control">
            <label class="label"><span class="label-text">Adicionar novas fotos</span></label>
            <input ref="fotoInput" type="file" multiple accept="image/jpeg,image/png,image/webp" class="file-input file-input-bordered" @change="handleFileInput" />
          </div>

          <div v-if="fotosArray.length" class="mt-3">
            <p class="text-sm font-medium mb-2">{{ fotosArray.length }} nova(s) foto(s)</p>
            <div class="flex flex-wrap gap-2">
              <div v-for="(foto, i) in fotosArray" :key="i" class="relative w-24 h-24">
                <img :src="foto.url" class="w-full h-full object-cover rounded-box" />
                <button type="button" class="btn btn-xs btn-circle btn-error absolute -top-2 -right-2" @click="removeFoto(i)">×</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="flex gap-3">
        <button type="submit" class="btn btn-primary" :disabled="form.processing">
          Salvar Alterações
        </button>
        <Link :href="route('admin.imoveis.index')" class="btn btn-ghost">Cancelar</Link>
      </div>
    </form>
  </div>
</template>