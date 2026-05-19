<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  imovelId: Number,
})

const form = useForm({
  nome: '',
  email: '',
  telefone: '',
  tipo_proposta: 'comprar',
  valor_proposta: '',
  mensagem: '',
})

function submit() {
  form.post(route('imoveis.propostas.store', props.imovelId), {
    preserveScroll: true,
  })
}

function formatCurrency(v) {
  let val = v.replace(/\D/g, '')
  val = (parseInt(val) / 100).toFixed(2)
  return val.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.')
}

function onValorInput(e) {
  const raw = e.target.value.replace(/\D/g, '')
  if (raw === '') {
    form.valor_proposta = ''
    return
  }
  const num = (parseInt(raw) / 100).toFixed(2)
  form.valor_proposta = num
  e.target.value = num.replace('.', ',')
}
</script>

<template>
  <form @submit.prevent="submit" class="space-y-4">
    <div v-if="form.recentlySuccessful" class="alert alert-success">
      Proposta enviada com sucesso! Entraremos em contato.
    </div>

    <div class="form-control">
      <label class="label"><span class="label-text">Tipo de Proposta</span></label>
      <div class="flex gap-4">
        <label class="flex items-center gap-2 cursor-pointer">
          <input type="radio" v-model="form.tipo_proposta" value="comprar" class="radio radio-primary" />
          <span>Comprar</span>
        </label>
        <label class="flex items-center gap-2 cursor-pointer">
          <input type="radio" v-model="form.tipo_proposta" value="alugar" class="radio radio-primary" />
          <span>Alugar</span>
        </label>
      </div>
    </div>

    <div class="form-control">
      <label class="label" for="proposta-nome"><span class="label-text">Nome</span></label>
      <input id="proposta-nome" v-model="form.nome" type="text" class="input input-bordered" :class="{ 'input-error': form.errors.nome }" required />
      <label v-if="form.errors.nome" class="label"><span class="label-text-alt text-error">{{ form.errors.nome }}</span></label>
    </div>

    <div class="form-control">
      <label class="label" for="proposta-email"><span class="label-text">Email</span></label>
      <input id="proposta-email" v-model="form.email" type="email" class="input input-bordered" :class="{ 'input-error': form.errors.email }" required />
      <label v-if="form.errors.email" class="label"><span class="label-text-alt text-error">{{ form.errors.email }}</span></label>
    </div>

    <div class="form-control">
      <label class="label" for="proposta-telefone"><span class="label-text">Telefone</span></label>
      <input id="proposta-telefone" v-model="form.telefone" type="text" class="input input-bordered" :class="{ 'input-error': form.errors.telefone }" required />
      <label v-if="form.errors.telefone" class="label"><span class="label-text-alt text-error">{{ form.errors.telefone }}</span></label>
    </div>

    <div class="form-control">
      <label class="label" for="proposta-valor"><span class="label-text">Valor da Proposta (opcional)</span></label>
      <input id="proposta-valor" type="text" class="input input-bordered" :class="{ 'input-error': form.errors.valor_proposta }" placeholder="R$ 0,00" @input="onValorInput" />
      <label v-if="form.errors.valor_proposta" class="label"><span class="label-text-alt text-error">{{ form.errors.valor_proposta }}</span></label>
    </div>

    <div class="form-control">
      <label class="label" for="proposta-mensagem"><span class="label-text">Mensagem (opcional)</span></label>
      <textarea id="proposta-mensagem" v-model="form.mensagem" class="textarea textarea-bordered" rows="3"></textarea>
    </div>

    <button type="submit" class="btn btn-primary w-full" :disabled="form.processing">
      Enviar Proposta
    </button>
  </form>
</template>