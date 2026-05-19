<script setup>
import { ref, onMounted, onUnmounted, reactive } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  imoveis: Object,
})

function formatPrice(value) {
  return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value)
}

function formatArea(value) {
  if (!value) return null
  return new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(value) + ' m²'
}

const statusBadge = (status) => {
  const map = {
    active: 'badge-success',
    sold: 'badge-error',
    rented: 'badge-warning',
    inactive: 'badge-ghost',
  }
  return map[status] || 'badge-ghost'
}

const deleteForm = useForm({})
const deletingId = ref(null)
const imagesLoaded = reactive({})

function confirmDelete(id) {
  deletingId.value = id
  document.getElementById('delete-modal').showModal()
}

function deleteImovel() {
  if (!deletingId.value) return
  deleteForm.delete(route('admin.imoveis.destroy', deletingId.value), {
    preserveScroll: true,
    onSuccess: () => {
      deletingId.value = null
      document.getElementById('delete-modal').close()
    },
  })
}

const statusLabel = (status) => {
  const map = {
    active: 'Ativo',
    sold: 'Vendido',
    rented: 'Alugado',
    inactive: 'Inativo',
  }
  return map[status] || status
}

const carouselIndex = reactive({})
const intervalMap = {}
const lightboxImovel = ref(null)
const lightboxIndex = ref(0)

function nextSlide(id, fotos) {
  if (!fotos?.length) return
  carouselIndex[id] = (carouselIndex[id] ?? 0) + 1
  if (carouselIndex[id] >= fotos.length) carouselIndex[id] = 0
}

function prevSlide(id, fotos) {
  if (!fotos?.length) return
  carouselIndex[id] = (carouselIndex[id] ?? 0) - 1
  if (carouselIndex[id] < 0) carouselIndex[id] = fotos.length - 1
}

function startCarousel(id, fotos) {
  if (!fotos?.length || intervalMap[id]) return
  intervalMap[id] = setInterval(() => nextSlide(id, fotos), 4000)
}

function stopCarousel(id) {
  if (intervalMap[id]) {
    clearInterval(intervalMap[id])
    delete intervalMap[id]
  }
}

function getImageUrl(caminho) {
  return '/storage/' + caminho
}

function openLightbox(imovel, index) {
  lightboxImovel.value = imovel
  lightboxIndex.value = index
  document.getElementById('lightbox-modal').showModal()
}

function lightboxPrev(fotos) {
  lightboxIndex.value = lightboxIndex.value - 1
  if (lightboxIndex.value < 0) lightboxIndex.value = fotos.length - 1
}

function lightboxNext(fotos) {
  lightboxIndex.value = lightboxIndex.value + 1
  if (lightboxIndex.value >= fotos.length) lightboxIndex.value = 0
}

function onImageLoad(imovelId) {
  imagesLoaded[imovelId] = true
}

onMounted(() => {
  if (props.imoveis?.data) {
    for (const imovel of props.imoveis.data) {
      if (imovel.fotos?.length > 1) {
        carouselIndex[imovel.id] = 0
      }
    }
  }
})

onUnmounted(() => {
  for (const key of Object.keys(intervalMap)) {
    clearInterval(intervalMap[key])
  }
})
</script>

<template>
  <Head title="Meus Imóveis" />

  <div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <h1 class="text-2xl sm:text-3xl font-bold">Meus Imóveis</h1>
      <Link :href="route('imovel.create')" class="btn btn-primary">
        Novo Imóvel
      </Link>
    </div>

    <div v-if="!imoveis.data.length" class="text-center py-16">
      <div class="text-6xl mb-4 text-base-content/30">
        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
      </div>
      <h2 class="text-xl font-semibold mb-2">Nenhum imóvel anunciado</h2>
      <p class="text-base-content/60 mb-6">Comece anunciando seu primeiro imóvel.</p>
      <Link :href="route('imovel.create')" class="btn btn-primary btn-lg">
        Anunciar Imóvel
      </Link>
    </div>

    <div v-else class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
      <div v-for="imovel in imoveis.data" :key="imovel.id" class="card bg-base-100 shadow-sm hover:shadow-md transition-all duration-300 group/card">
        <figure
          class="h-44 sm:h-48 overflow-hidden relative cursor-pointer bg-base-200"
          @mouseenter="startCarousel(imovel.id, imovel.fotos)"
          @mouseleave="stopCarousel(imovel.id)"
          @click="openLightbox(imovel, carouselIndex[imovel.id] ?? 0)"
        >
          <div v-if="!imagesLoaded[imovel.id]" class="absolute inset-0 skeleton" />

          <template v-if="imovel.fotos?.length">
            <img
              :src="getImageUrl(imovel.fotos[carouselIndex[imovel.id] ?? 0]?.caminho)"
              :alt="imovel.titulo"
              class="w-full h-full object-cover transition-opacity duration-300"
              :class="imagesLoaded[imovel.id] ? 'opacity-100' : 'opacity-0'"
              @load="onImageLoad(imovel.id)"
            />
            <button
              v-if="imovel.fotos.length > 1"
              class="absolute left-1 top-1/2 -translate-y-1/2 btn btn-circle btn-ghost btn-xs opacity-0 group-hover/card:opacity-100 transition-opacity bg-black/40 hover:bg-black/60 text-white border-0"
              @click.stop="prevSlide(imovel.id, imovel.fotos)"
              aria-label="Foto anterior"
            >
              ❮
            </button>
            <button
              v-if="imovel.fotos.length > 1"
              class="absolute right-1 top-1/2 -translate-y-1/2 btn btn-circle btn-ghost btn-xs opacity-0 group-hover/card:opacity-100 transition-opacity bg-black/40 hover:bg-black/60 text-white border-0"
              @click.stop="nextSlide(imovel.id, imovel.fotos)"
              aria-label="Próxima foto"
            >
              ❯
            </button>
            <div
              v-if="imovel.fotos.length > 1"
              class="absolute bottom-1.5 left-1/2 -translate-x-1/2 flex gap-1"
            >
              <span
                v-for="(foto, fi) in imovel.fotos"
                :key="fi"
                class="w-1.5 h-1.5 rounded-full transition-all duration-200"
                :class="(carouselIndex[imovel.id] ?? 0) === fi ? 'bg-white scale-110' : 'bg-white/50'"
              />
            </div>
          </template>
          <div v-else class="w-full h-full bg-base-200 flex items-center justify-center text-base-content/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
          </div>
        </figure>
        <div class="card-body p-4">
          <div class="flex items-start justify-between gap-2">
            <h2 class="card-title text-sm sm:text-base truncate">{{ imovel.titulo }}</h2>
            <span class="badge badge-sm shrink-0" :class="statusBadge(imovel.status)">{{ statusLabel(imovel.status) }}</span>
          </div>

          <p class="text-xs sm:text-sm text-base-content/60 truncate">
            {{ imovel.cidade }}{{ imovel.estado ? '/' + imovel.estado : '' }}
          </p>

          <p class="text-lg font-bold text-primary">{{ formatPrice(imovel.preco) }}</p>

          <div class="flex flex-wrap gap-1 text-xs text-base-content/60">
            <span v-if="imovel.area">{{ formatArea(imovel.area) }}</span>
            <span v-if="imovel.quartos">{{ imovel.quartos }} quarto{{ imovel.quartos > 1 ? 's' : '' }}</span>
            <span v-if="imovel.banheiros">{{ imovel.banheiros }} banheiro{{ imovel.banheiros > 1 ? 's' : '' }}</span>
            <span v-if="imovel.vagas">{{ imovel.vagas }} vaga{{ imovel.vagas > 1 ? 's' : '' }}</span>
          </div>

          <div class="flex flex-wrap gap-1 mt-1">
            <span v-if="imovel.categoria" class="badge badge-soft badge-info badge-sm">{{ imovel.categoria.nome }}</span>
            <span v-if="imovel.tipo_negocio" class="badge badge-soft badge-accent badge-sm">{{ imovel.tipo_negocio.nome }}</span>
          </div>

          <div class="flex items-center gap-2 mt-2 text-xs text-base-content/40">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            {{ imovel.views || 0 }} visualizações
          </div>

          <div class="flex gap-1 mt-2 pt-2 border-t border-base-200">
            <Link :href="route('admin.imoveis.show', imovel.id)" class="btn btn-ghost btn-sm flex-1">
              Detalhes
            </Link>
            <Link :href="route('admin.imoveis.edit', imovel.id)" class="btn btn-ghost btn-sm">
              Editar
            </Link>
            <button
              class="btn btn-ghost btn-sm text-error hover:bg-error/10"
              @click="confirmDelete(imovel.id)"
            >
              Excluir
            </button>
          </div>
        </div>
      </div>
    </div>

    <div v-if="imoveis.links && imoveis.links.length > 3" class="flex justify-center pt-2">
      <div class="join">
        <template v-for="(link, i) in imoveis.links" :key="i">
          <Link
            v-if="link.url"
            :href="link.url"
            class="join-item btn btn-sm min-w-10"
            :class="{ 'btn-active': link.active }"
          >
            <span v-if="link.label.includes('Previous') || link.label.includes('‹')" class="hidden sm:inline">Anterior</span>
            <span v-else-if="link.label.includes('Next') || link.label.includes('›')" class="hidden sm:inline">Próximo</span>
            <span v-else>{{ link.label }}</span>
          </Link>
          <span v-else class="join-item btn btn-sm btn-disabled min-w-10">
            <span v-if="link.label.includes('Previous') || link.label.includes('‹')" class="hidden sm:inline">Anterior</span>
            <span v-else-if="link.label.includes('Next') || link.label.includes('›')" class="hidden sm:inline">Próximo</span>
            <span v-else>{{ link.label }}</span>
          </span>
        </template>
      </div>
    </div>
  </div>

  <dialog id="lightbox-modal" class="modal">
    <div class="modal-box max-w-4xl p-0 bg-black/90 overflow-hidden">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 z-10 text-white hover:bg-white/20" aria-label="Fechar">
          ✕
        </button>
      </form>
      <div v-if="lightboxImovel?.fotos?.length" class="relative flex items-center justify-center h-[80vh]">
        <img
          :key="lightboxIndex"
          :src="getImageUrl(lightboxImovel.fotos[lightboxIndex]?.caminho)"
          :alt="lightboxImovel.titulo"
          class="max-w-full max-h-full object-contain p-4"
        />
        <button
          v-if="lightboxImovel.fotos.length > 1"
          class="absolute left-2 top-1/2 -translate-y-1/2 btn btn-circle btn-ghost text-white bg-black/30 hover:bg-black/60 border-0"
          @click.stop="lightboxPrev(lightboxImovel.fotos)"
          aria-label="Anterior"
        >
          ❮
        </button>
        <button
          v-if="lightboxImovel.fotos.length > 1"
          class="absolute right-2 top-1/2 -translate-y-1/2 btn btn-circle btn-ghost text-white bg-black/30 hover:bg-black/60 border-0"
          @click.stop="lightboxNext(lightboxImovel.fotos)"
          aria-label="Próxima"
        >
          ❯
        </button>
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
          <span
            v-for="(foto, fi) in lightboxImovel.fotos"
            :key="fi"
            class="w-2 h-2 rounded-full cursor-pointer transition-all duration-200"
            :class="lightboxIndex === fi ? 'bg-white scale-125' : 'bg-white/40 hover:bg-white/70'"
            @click="lightboxIndex = fi"
          />
        </div>
      </div>
    </div>
    <form method="dialog" class="modal-backdrop">
      <button>fechar</button>
    </form>
  </dialog>

  <dialog id="delete-modal" class="modal">
    <div class="modal-box">
      <h3 class="text-lg font-bold">Excluir Imóvel</h3>
      <p class="py-4">Tem certeza que deseja excluir este imóvel? Esta ação não pode ser desfeita.</p>
      <div class="modal-action">
        <form method="dialog">
          <button class="btn btn-ghost">Cancelar</button>
        </form>
        <button class="btn btn-error" :disabled="deleteForm.processing" @click="deleteImovel">
          <span v-if="deleteForm.processing" class="loading loading-spinner loading-sm"></span>
          <span v-else>Excluir</span>
        </button>
      </div>
    </div>
    <form method="dialog" class="modal-backdrop">
      <button>fechar</button>
    </form>
  </dialog>
</template>
