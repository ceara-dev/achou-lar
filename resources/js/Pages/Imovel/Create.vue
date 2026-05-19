<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  categorias: Array,
  tipos: Array,
})

const form = useForm({
  categoria_id: '',
  tipo_negocio_id: '',
  titulo: '',
  descricao: '',
  regras: '',
  preco: '',
  valor_condominio: '',
  iptu: '',
  inclui_agua: false,
  inclui_energia: false,
  inclui_internet: false,
  area: '',
  quartos: '',
  banheiros: '',
  cozinhas: '',
  vagas: '',
  tipo_residencia: '',
  endereco: '',
  numero: '',
  bairro: '',
  cidade: '',
  estado: '',
  cep: '',
  data_inicio: '',
  data_fim: '',
  fotos: [],
})

const fotosArray = ref([])
const fotoInput = ref(null)
const temporadaTipo = ref(false)
const isDragOver = ref(false)

const selectedTipo = ref(null)

function onTipoChange() {
  const tipo = props.tipos.find(t => t.id == form.tipo_negocio_id)
  selectedTipo.value = tipo
  temporadaTipo.value = tipo?.slug === 'temporada'
}

function applyCepMask() {
  let value = form.cep.replace(/\D/g, '').slice(0, 8)
  if (value.length > 5) {
    value = value.slice(0, 5) + '-' + value.slice(5)
  }
  form.cep = value
}

async function buscaCEP() {
  const cep = form.cep.replace(/\D/g, '')
  if (cep.length !== 8) return
  try {
    const res = await fetch(`https://viacep.com.br/ws/${cep}/json/`)
    const data = await res.json()
    if (!data.erro) {
      form.endereco = data.logradouro
      form.bairro = data.bairro
      form.cidade = data.localidade
      form.estado = data.uf
    }
  } catch (e) {
    // silent
  }
}

function handleDrop(e) {
  isDragOver.value = false
  const files = e.dataTransfer.files
  for (const file of files) {
    fotosArray.value.push({
      file,
      url: URL.createObjectURL(file),
    })
  }
}

function handleFileInput(e) {
  const files = e.target.files
  for (const file of files) {
    fotosArray.value.push({
      file,
      url: URL.createObjectURL(file),
    })
  }
  e.target.value = ''
}

function removeFoto(index) {
  URL.revokeObjectURL(fotosArray.value[index].url)
  fotosArray.value.splice(index, 1)
}

let dragIndex = null

function onDragStart(index) {
  dragIndex = index
}

function onDragOver(e) {
  e.preventDefault()
}

function onDrop(index) {
  if (dragIndex === null || dragIndex === index) return
  const item = fotosArray.value.splice(dragIndex, 1)[0]
  fotosArray.value.splice(index, 0, item)
  dragIndex = null
}

function submit() {
  if (form.numero) {
    form.endereco = form.endereco
      ? `${form.endereco}, ${form.numero}`
      : form.numero
  }
  form.fotos = fotosArray.value.map(f => f.file)
  form.post(route('imovel.store'), {
    forceFormData: true,
    onSuccess: () => {
      fotosArray.value.forEach(f => URL.revokeObjectURL(f.url))
      fotosArray.value = []
    },
  })
}
</script>

<template>
  <Head title="Anunciar Imóvel" />

  <div class="max-w-4xl mx-auto pb-28 sm:pb-8">
    <div class="mb-6">
      <h1 class="text-2xl sm:text-3xl font-bold">Anunciar Imóvel</h1>
      <p class="text-sm text-base-content/60 mt-1">Preencha os dados do seu imóvel para publicar o anúncio</p>
    </div>

    <form id="imovel-form" @submit.prevent="submit" class="space-y-6">
      <div class="bg-base-100 rounded-box shadow-sm p-4 sm:p-6 space-y-4">
        <h2 class="text-base sm:text-lg font-semibold flex items-center gap-2">
          <span class="w-7 h-7 rounded-full bg-primary text-primary-content text-sm flex items-center justify-center shrink-0">1</span>
          Tipo
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-control">
            <label class="label"><span class="label-text">Categoria</span></label>
            <select v-model="form.categoria_id" class="select select-bordered transition-all duration-200" :class="{ 'select-error': form.errors.categoria_id }">
              <option value="">Selecione...</option>
              <option v-for="cat in categorias" :key="cat.id" :value="cat.id">{{ cat.nome }}</option>
            </select>
            <span v-if="form.errors.categoria_id" class="text-error text-xs mt-1 flex items-center gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
              {{ form.errors.categoria_id }}
            </span>
          </div>

          <div class="form-control">
            <label class="label"><span class="label-text">Tipo de Negócio</span></label>
            <select v-model="form.tipo_negocio_id" class="select select-bordered transition-all duration-200" :class="{ 'select-error': form.errors.tipo_negocio_id }" @change="onTipoChange">
              <option value="">Selecione...</option>
              <option v-for="tipo in tipos" :key="tipo.id" :value="tipo.id">{{ tipo.nome }}</option>
            </select>
            <span v-if="form.errors.tipo_negocio_id" class="text-error text-xs mt-1 flex items-center gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
              {{ form.errors.tipo_negocio_id }}
            </span>
          </div>
        </div>

        <div v-if="temporadaTipo" class="grid grid-cols-1 md:grid-cols-2 gap-4 animate-[fadeIn_0.3s_ease-out]">
          <div class="form-control">
            <label class="label"><span class="label-text">Data de Início</span></label>
            <input v-model="form.data_inicio" type="date" class="input input-bordered transition-all duration-200" :class="{ 'input-error': form.errors.data_inicio }" />
            <span v-if="form.errors.data_inicio" class="text-error text-xs mt-1 flex items-center gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
              {{ form.errors.data_inicio }}
            </span>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">Data de Fim</span></label>
            <input v-model="form.data_fim" type="date" class="input input-bordered transition-all duration-200" :class="{ 'input-error': form.errors.data_fim }" />
            <span v-if="form.errors.data_fim" class="text-error text-xs mt-1 flex items-center gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
              {{ form.errors.data_fim }}
            </span>
          </div>
        </div>
      </div>

      <div class="bg-base-100 rounded-box shadow-sm p-4 sm:p-6 space-y-4">
        <h2 class="text-base sm:text-lg font-semibold flex items-center gap-2">
          <span class="w-7 h-7 rounded-full bg-primary text-primary-content text-sm flex items-center justify-center shrink-0">2</span>
          Dados Principais
        </h2>

        <div class="form-control">
          <label class="label"><span class="label-text">Título do Anúncio</span></label>
          <input v-model="form.titulo" type="text" class="input input-bordered transition-all duration-200" :class="{ 'input-error': form.errors.titulo }" />
          <span v-if="form.errors.titulo" class="text-error text-xs mt-1 flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ form.errors.titulo }}
          </span>
        </div>

        <div class="form-control">
          <label class="label"><span class="label-text">Descrição</span></label>
          <textarea v-model="form.descricao" class="textarea textarea-bordered h-32" :class="{ 'textarea-error': form.errors.descricao }"></textarea>
          <span v-if="form.errors.descricao" class="text-error text-xs mt-1 flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ form.errors.descricao }}
          </span>
        </div>

        <div class="form-control">
          <label class="label"><span class="label-text">Regras</span></label>
          <textarea v-model="form.regras" class="textarea textarea-bordered h-24" :class="{ 'textarea-error': form.errors.regras }"></textarea>
          <span v-if="form.errors.regras" class="text-error text-xs mt-1 flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ form.errors.regras }}
          </span>
        </div>
      </div>

      <div class="bg-base-100 rounded-box shadow-sm p-4 sm:p-6 space-y-4">
        <h2 class="text-base sm:text-lg font-semibold flex items-center gap-2">
          <span class="w-7 h-7 rounded-full bg-primary text-primary-content text-sm flex items-center justify-center shrink-0">3</span>
          Números do Imóvel
        </h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3 sm:gap-4">
          <div class="form-control">
            <label class="label py-1"><span class="label-text text-xs sm:text-sm">Área (m²)</span></label>
            <input v-model="form.area" type="number" step="0.01" min="0" class="input input-bordered transition-all duration-200" :class="{ 'input-error': form.errors.area }" />
            <span v-if="form.errors.area" class="text-error text-xs mt-1">{{ form.errors.area }}</span>
          </div>
          <div class="form-control">
            <label class="label py-1"><span class="label-text text-xs sm:text-sm">Quartos</span></label>
            <input v-model="form.quartos" type="number" min="0" class="input input-bordered transition-all duration-200" :class="{ 'input-error': form.errors.quartos }" />
            <span v-if="form.errors.quartos" class="text-error text-xs mt-1">{{ form.errors.quartos }}</span>
          </div>
          <div class="form-control">
            <label class="label py-1"><span class="label-text text-xs sm:text-sm">Banheiros</span></label>
            <input v-model="form.banheiros" type="number" min="0" class="input input-bordered transition-all duration-200" :class="{ 'input-error': form.errors.banheiros }" />
            <span v-if="form.errors.banheiros" class="text-error text-xs mt-1">{{ form.errors.banheiros }}</span>
          </div>
          <div class="form-control">
            <label class="label py-1"><span class="label-text text-xs sm:text-sm">Cozinhas</span></label>
            <input v-model="form.cozinhas" type="number" min="0" class="input input-bordered transition-all duration-200" :class="{ 'input-error': form.errors.cozinhas }" />
            <span v-if="form.errors.cozinhas" class="text-error text-xs mt-1">{{ form.errors.cozinhas }}</span>
          </div>
          <div class="form-control">
            <label class="label py-1"><span class="label-text text-xs sm:text-sm">Vagas</span></label>
            <input v-model="form.vagas" type="number" min="0" class="input input-bordered transition-all duration-200" :class="{ 'input-error': form.errors.vagas }" />
            <span v-if="form.errors.vagas" class="text-error text-xs mt-1">{{ form.errors.vagas }}</span>
          </div>
        </div>

        <div class="form-control max-w-xs">
          <label class="label"><span class="label-text">Tipo de Residência</span></label>
          <select v-model="form.tipo_residencia" class="select select-bordered">
            <option value="">Não informado</option>
            <option value="residencial">Residencial</option>
            <option value="comercial">Comercial</option>
          </select>
          <span v-if="form.errors.tipo_residencia" class="text-error text-xs mt-1">{{ form.errors.tipo_residencia }}</span>
        </div>
      </div>

      <div class="bg-base-100 rounded-box shadow-sm p-4 sm:p-6 space-y-4">
        <h2 class="text-base sm:text-lg font-semibold flex items-center gap-2">
          <span class="w-7 h-7 rounded-full bg-primary text-primary-content text-sm flex items-center justify-center shrink-0">4</span>
          Endereço
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="form-control">
            <label class="label"><span class="label-text">CEP</span></label>
            <input
              v-model="form.cep"
              type="text"
              maxlength="9"
              class="input input-bordered transition-all duration-200"
              :class="{ 'input-error': form.errors.cep }"
              @input="applyCepMask"
              @blur="buscaCEP"
              placeholder="00000-000"
            />
            <span v-if="form.errors.cep" class="text-error text-xs mt-1">{{ form.errors.cep }}</span>
          </div>
          <div class="form-control md:col-span-2">
            <label class="label"><span class="label-text">Logradouro</span></label>
            <input v-model="form.endereco" type="text" class="input input-bordered transition-all duration-200" :class="{ 'input-error': form.errors.endereco }" />
            <span v-if="form.errors.endereco" class="text-error text-xs mt-1">{{ form.errors.endereco }}</span>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
          <div class="form-control">
            <label class="label"><span class="label-text">Número</span></label>
            <input v-model="form.numero" type="text" class="input input-bordered transition-all duration-200" />
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">Bairro</span></label>
            <input v-model="form.bairro" type="text" class="input input-bordered transition-all duration-200" :class="{ 'input-error': form.errors.bairro }" />
            <span v-if="form.errors.bairro" class="text-error text-xs mt-1">{{ form.errors.bairro }}</span>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">Cidade</span></label>
            <input v-model="form.cidade" type="text" class="input input-bordered transition-all duration-200" :class="{ 'input-error': form.errors.cidade }" />
            <span v-if="form.errors.cidade" class="text-error text-xs mt-1">{{ form.errors.cidade }}</span>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">Estado</span></label>
            <input v-model="form.estado" type="text" maxlength="2" class="input input-bordered uppercase transition-all duration-200" :class="{ 'input-error': form.errors.estado }" />
            <span v-if="form.errors.estado" class="text-error text-xs mt-1">{{ form.errors.estado }}</span>
          </div>
        </div>
      </div>

      <div class="bg-base-100 rounded-box shadow-sm p-4 sm:p-6 space-y-4">
        <h2 class="text-base sm:text-lg font-semibold flex items-center gap-2">
          <span class="w-7 h-7 rounded-full bg-primary text-primary-content text-sm flex items-center justify-center shrink-0">5</span>
          Preço
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div class="form-control">
            <label class="label"><span class="label-text">Preço</span></label>
            <div class="relative">
              <span class="absolute left-3 top-1/2 -translate-y-1/2 text-base-content/40 text-sm">R$</span>
              <input v-model="form.preco" type="number" step="0.01" min="0" class="input input-bordered w-full pl-9 transition-all duration-200" :class="{ 'input-error': form.errors.preco }" />
            </div>
            <span v-if="form.errors.preco" class="text-error text-xs mt-1">{{ form.errors.preco }}</span>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">Valor Condomínio</span></label>
            <div class="relative">
              <span class="absolute left-3 top-1/2 -translate-y-1/2 text-base-content/40 text-sm">R$</span>
              <input v-model="form.valor_condominio" type="number" step="0.01" min="0" class="input input-bordered w-full pl-9 transition-all duration-200" :class="{ 'input-error': form.errors.valor_condominio }" />
            </div>
            <span v-if="form.errors.valor_condominio" class="text-error text-xs mt-1">{{ form.errors.valor_condominio }}</span>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text">IPTU</span></label>
            <div class="relative">
              <span class="absolute left-3 top-1/2 -translate-y-1/2 text-base-content/40 text-sm">R$</span>
              <input v-model="form.iptu" type="number" step="0.01" min="0" class="input input-bordered w-full pl-9 transition-all duration-200" :class="{ 'input-error': form.errors.iptu }" />
            </div>
            <span v-if="form.errors.iptu" class="text-error text-xs mt-1">{{ form.errors.iptu }}</span>
          </div>
        </div>

        <div class="form-control">
          <label class="label"><span class="label-text">Utilidades inclusas</span></label>
          <div class="flex flex-wrap gap-6">
            <label class="label cursor-pointer justify-start gap-2">
              <input v-model="form.inclui_agua" type="checkbox" class="checkbox checkbox-primary" />
              <span class="label-text">Água</span>
            </label>
            <label class="label cursor-pointer justify-start gap-2">
              <input v-model="form.inclui_energia" type="checkbox" class="checkbox checkbox-primary" />
              <span class="label-text">Energia</span>
            </label>
            <label class="label cursor-pointer justify-start gap-2">
              <input v-model="form.inclui_internet" type="checkbox" class="checkbox checkbox-primary" />
              <span class="label-text">Internet</span>
            </label>
          </div>
        </div>
      </div>

      <div class="bg-base-100 rounded-box shadow-sm p-4 sm:p-6 space-y-4">
        <h2 class="text-base sm:text-lg font-semibold flex items-center gap-2">
          <span class="w-7 h-7 rounded-full bg-primary text-primary-content text-sm flex items-center justify-center shrink-0">6</span>
          Fotos
        </h2>

        <div
          class="border-2 border-dashed rounded-box p-8 text-center cursor-pointer transition-all duration-200"
          :class="isDragOver ? 'border-primary bg-primary/5 scale-[1.02]' : 'border-base-300 hover:border-primary/50 hover:bg-base-200/50'"
          @dragover.prevent="isDragOver = true"
          @dragleave.prevent="isDragOver = false"
          @drop.prevent="handleDrop"
          @click="fotoInput?.click()"
        >
          <div class="transition-transform duration-200" :class="{ 'scale-110': isDragOver }">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" :class="isDragOver ? 'text-primary' : 'text-base-content/30'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            <p class="mt-2 text-sm" :class="isDragOver ? 'text-primary font-medium' : 'text-base-content/60'">
              {{ isDragOver ? 'Solte as fotos aqui' : 'Arraste fotos aqui ou clique para selecionar' }}
            </p>
            <p class="text-xs text-base-content/40 mt-1">JPEG, PNG ou WebP · Máx 5MB cada</p>
          </div>
        </div>

        <input
          ref="fotoInput"
          type="file"
          accept="image/jpeg,image/png,image/webp"
          multiple
          class="hidden"
          @change="handleFileInput"
        />

        <div v-if="fotosArray.length" class="flex items-center justify-between">
          <p class="text-sm font-medium flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            {{ fotosArray.length }} foto{{ fotosArray.length > 1 ? 's' : '' }} selecionada{{ fotosArray.length > 1 ? 's' : '' }}
          </p>
          <span v-if="form.errors.fotos" class="text-error text-sm">{{ form.errors.fotos }}</span>
        </div>

        <div
          v-if="fotosArray.length"
          class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3"
        >
          <div
            v-for="(foto, index) in fotosArray"
            :key="foto.url"
            class="relative group rounded-box overflow-hidden border border-base-300 aspect-square"
            draggable="true"
            @dragstart="onDragStart(index)"
            @dragover="onDragOver"
            @drop="onDrop(index)"
          >
            <img :src="foto.url" class="w-full h-full object-cover" alt="" />
            <button
              type="button"
              class="absolute top-1 right-1 btn btn-circle btn-xs btn-error opacity-0 group-hover:opacity-100 transition-opacity"
              @click="removeFoto(index)"
              aria-label="Remover foto"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <div class="absolute top-1 left-1 bg-base-100/80 text-xs px-1.5 py-0.5 rounded font-mono">
              {{ index + 1 }}
            </div>
          </div>
        </div>
      </div>

      <div class="hidden sm:flex gap-3">
        <button type="submit" class="btn btn-primary flex-1" :disabled="form.processing">
          <span v-if="form.processing" class="loading loading-spinner"></span>
          <span v-else>Publicar Anúncio</span>
        </button>
        <Link :href="route('admin.imoveis.index')" class="btn btn-ghost">
          Cancelar
        </Link>
      </div>

      <div class="fixed bottom-0 left-0 right-0 sm:hidden bg-base-100 border-t border-base-200 p-3 flex gap-3 z-40 shadow-lg">
        <Link :href="route('admin.imoveis.index')" class="btn btn-ghost flex-1">
          Cancelar
        </Link>
        <button type="submit" class="btn btn-primary flex-1" :disabled="form.processing">
          <span v-if="form.processing" class="loading loading-spinner loading-sm"></span>
          <span v-else>Publicar</span>
        </button>
      </div>
    </form>
  </div>
</template>
