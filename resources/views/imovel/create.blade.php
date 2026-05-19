@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Anunciar Imóvel</h1>
    <p class="text-base-content/60">Preencha os dados do imóvel para publicar seu anúncio</p>
</div>

<form method="POST" action="{{ route('imovel.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="space-y-6">
        {{-- Categoria e Tipo --}}
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-4">Tipo do Imóvel</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label" for="categoria_id">
                            <span class="label-text">Categoria</span>
                        </label>
                        <select id="categoria_id" name="categoria_id"
                                class="select select-bordered w-full @error('categoria_id') select-error @enderror" required>
                            <option value="">Selecione...</option>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label" for="tipo_negocio_id">
                            <span class="label-text">Tipo de Negócio</span>
                        </label>
                        <select id="tipo_negocio_id" name="tipo_negocio_id"
                                class="select select-bordered w-full @error('tipo_negocio_id') select-error @enderror" required>
                            <option value="">Selecione...</option>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}" data-slug="{{ $tipo->slug }}"
                                    {{ old('tipo_negocio_id') == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_negocio_id')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>

                <div id="datas-temporada" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4{{ old('tipo_negocio_id') && \App\Models\TipoNegocio::find(old('tipo_negocio_id'))?->slug === 'temporada' ? '' : ' hidden' }}">
                    <div class="form-control">
                        <label class="label" for="data_inicio">
                            <span class="label-text">Data de Início</span>
                        </label>
                        <input id="data_inicio" type="date" name="data_inicio" value="{{ old('data_inicio') }}"
                               class="input input-bordered w-full @error('data_inicio') input-error @enderror" />
                        @error('data_inicio')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label class="label" for="data_fim">
                            <span class="label-text">Data de Fim</span>
                        </label>
                        <input id="data_fim" type="date" name="data_fim" value="{{ old('data_fim') }}"
                               class="input input-bordered w-full @error('data_fim') input-error @enderror" />
                        @error('data_fim')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Dados Principais --}}
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-4">Dados do Imóvel</h2>

                <div class="form-control mb-4">
                    <label class="label" for="titulo">
                        <span class="label-text">Título do Anúncio</span>
                    </label>
                    <input id="titulo" type="text" name="titulo" value="{{ old('titulo') }}"
                           class="input input-bordered w-full @error('titulo') input-error @enderror"
                           placeholder="Ex: Casa espaçosa no centro" required />
                    @error('titulo')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="form-control mb-4">
                    <label class="label" for="descricao">
                        <span class="label-text">Descrição</span>
                    </label>
                    <textarea id="descricao" name="descricao" rows="5"
                              class="textarea textarea-bordered w-full @error('descricao') textarea-error @enderror"
                              placeholder="Descreva o imóvel em detalhes..." required>{{ old('descricao') }}</textarea>
                    @error('descricao')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="form-control mb-4">
                    <label class="label" for="regras">
                        <span class="label-text">Regras do Imóvel</span>
                        <span class="label-text-alt text-base-content/40">Opcional</span>
                    </label>
                    <textarea id="regras" name="regras" rows="3"
                              class="textarea textarea-bordered w-full"
                              placeholder="Ex: Não aceita pets, não pode fazer reformas...">{{ old('regras') }}</textarea>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <div class="form-control">
                        <label class="label" for="area">
                            <span class="label-text">Área (m²)</span>
                        </label>
                        <input id="area" type="number" step="0.01" name="area" value="{{ old('area') }}"
                               class="input input-bordered w-full" placeholder="0" />
                    </div>

                    <div class="form-control">
                        <label class="label" for="quartos">
                            <span class="label-text">Quartos</span>
                        </label>
                        <input id="quartos" type="number" name="quartos" value="{{ old('quartos') }}"
                               class="input input-bordered w-full" placeholder="0" />
                    </div>

                    <div class="form-control">
                        <label class="label" for="banheiros">
                            <span class="label-text">Banheiros</span>
                        </label>
                        <input id="banheiros" type="number" name="banheiros" value="{{ old('banheiros') }}"
                               class="input input-bordered w-full" placeholder="0" />
                    </div>

                    <div class="form-control">
                        <label class="label" for="cozinhas">
                            <span class="label-text">Cozinhas</span>
                        </label>
                        <input id="cozinhas" type="number" name="cozinhas" value="{{ old('cozinhas') }}"
                               class="input input-bordered w-full" placeholder="0" />
                    </div>

                    <div class="form-control">
                        <label class="label" for="vagas">
                            <span class="label-text">Vagas de Garagem</span>
                        </label>
                        <input id="vagas" type="number" name="vagas" value="{{ old('vagas') }}"
                               class="input input-bordered w-full" placeholder="0" />
                    </div>
                </div>

                <div class="form-control mt-4">
                    <label class="label" for="tipo_residencia">
                        <span class="label-text">Tipo de Residência</span>
                        <span class="label-text-alt text-base-content/40">Opcional</span>
                    </label>
                    <select id="tipo_residencia" name="tipo_residencia"
                            class="select select-bordered w-full max-w-xs @error('tipo_residencia') select-error @enderror">
                        <option value="">Selecione...</option>
                        <option value="residencial" {{ old('tipo_residencia') == 'residencial' ? 'selected' : '' }}>Residencial</option>
                        <option value="comercial" {{ old('tipo_residencia') == 'comercial' ? 'selected' : '' }}>Comercial</option>
                    </select>
                    @error('tipo_residencia')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Endereço --}}
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-4">Endereço</h2>

                <div class="form-control mb-4">
                    <label class="label" for="cep">
                        <span class="label-text">CEP</span>
                    </label>
                    <div class="join w-full">
                        <input id="cep" type="text" name="cep" value="{{ old('cep') }}"
                               class="input input-bordered join-item flex-1 @error('cep') input-error @enderror"
                               placeholder="64000-000" maxlength="9"
                               data-cep-input />
                        <button type="button" id="cep-loading" class="btn join-item hidden">
                            <span class="loading loading-spinner loading-sm"></span>
                        </button>
                    </div>
                    <label class="label">
                        <span class="label-text-alt text-base-content/40">Ao preencher o CEP, os campos abaixo serão preenchidos automaticamente</span>
                    </label>
                    @error('cep')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="form-control md:col-span-2">
                        <label class="label" for="endereco">
                            <span class="label-text">Logradouro</span>
                        </label>
                        <input id="endereco" type="text" name="endereco" value="{{ old('endereco') }}"
                               class="input input-bordered w-full @error('endereco') input-error @enderror"
                               placeholder="Rua" required />
                        @error('endereco')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label" for="numero">
                            <span class="label-text">Número</span>
                        </label>
                        <input id="numero" type="text" name="numero" value="{{ old('numero') }}"
                               class="input input-bordered w-full" placeholder="S/N" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="form-control">
                        <label class="label" for="bairro">
                            <span class="label-text">Bairro</span>
                        </label>
                        <input id="bairro" type="text" name="bairro" value="{{ old('bairro') }}"
                               class="input input-bordered w-full" placeholder="Bairro" />
                    </div>

                    <div class="form-control">
                        <label class="label" for="cidade">
                            <span class="label-text">Cidade</span>
                        </label>
                        <input id="cidade" type="text" name="cidade" value="{{ old('cidade') }}"
                               class="input input-bordered w-full @error('cidade') input-error @enderror"
                               placeholder="Cidade" required />
                        @error('cidade')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label" for="estado">
                            <span class="label-text">Estado</span>
                        </label>
                        <input id="estado" type="text" name="estado" value="{{ old('estado') }}"
                               class="input input-bordered w-full @error('estado') input-error @enderror"
                               maxlength="2" placeholder="PI" required />
                        @error('estado')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="form-control">
                        <label class="label" for="latitude">
                            <span class="label-text">Latitude</span>
                        </label>
                        <input id="latitude" type="text" step="any" name="latitude" value="{{ old('latitude') }}"
                               class="input input-bordered w-full" placeholder="-5.092" />
                    </div>

                    <div class="form-control">
                        <label class="label" for="longitude">
                            <span class="label-text">Longitude</span>
                        </label>
                        <input id="longitude" type="text" step="any" name="longitude" value="{{ old('longitude') }}"
                               class="input input-bordered w-full" placeholder="-42.815" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Preço e Condições --}}
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-4">Preço e Condições</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="form-control">
                        <label class="label" for="preco">
                            <span class="label-text">Valor (R$)</span>
                        </label>
                        <input id="preco" type="number" step="0.01" name="preco" value="{{ old('preco') }}"
                               class="input input-bordered w-full @error('preco') input-error @enderror"
                               placeholder="0,00" required />
                        @error('preco')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label" for="valor_condominio">
                            <span class="label-text">Condomínio (R$)</span>
                        </label>
                        <input id="valor_condominio" type="number" step="0.01" name="valor_condominio"
                               value="{{ old('valor_condominio') }}"
                               class="input input-bordered w-full" placeholder="0,00" />
                    </div>

                    <div class="form-control">
                        <label class="label" for="iptu">
                            <span class="label-text">IPTU (R$)</span>
                        </label>
                        <input id="iptu" type="number" step="0.01" name="iptu" value="{{ old('iptu') }}"
                               class="input input-bordered w-full" placeholder="0,00" />
                    </div>
                </div>

                <div>
                    <label class="label">
                        <span class="label-text">Incluso no Valor</span>
                    </label>
                    <div class="flex flex-wrap gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="inclui_agua" value="1"
                                   class="checkbox checkbox-primary checkbox-sm"
                                   {{ old('inclui_agua') ? 'checked' : '' }} />
                            <span class="text-sm">Água</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="inclui_energia" value="1"
                                   class="checkbox checkbox-primary checkbox-sm"
                                   {{ old('inclui_energia') ? 'checked' : '' }} />
                            <span class="text-sm">Energia</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="inclui_internet" value="1"
                                   class="checkbox checkbox-primary checkbox-sm"
                                   {{ old('inclui_internet') ? 'checked' : '' }} />
                            <span class="text-sm">Internet</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Fotos --}}
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-4">Fotos</h2>
                <p class="text-sm text-base-content/60 mb-4">
                    Opcional. Se enviar, o mínimo é <strong>10 fotos</strong>.
                    Formatos: JPEG, PNG, WebP. Máx 5MB cada.
                </p>

                <div id="foto-upload-zone"
                     class="border-2 border-dashed border-base-300 rounded-box p-8 text-center cursor-pointer hover:border-primary transition-colors mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-3 text-base-content/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm font-medium">Clique para adicionar fotos</p>
                    <p class="text-xs text-base-content/40 mt-1">ou arraste e solte aqui</p>
                </div>

                <input id="foto-input" type="file" name="fotos[]" multiple
                       accept="image/jpeg,image/png,image/webp" class="hidden" />

                <div id="foto-counter" class="text-sm text-base-content/60 mb-3 hidden">
                    <span id="foto-count">0</span> foto(s) selecionada(s)
                </div>

                @error('fotos')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                @enderror
                @error('fotos.*')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                @enderror

                <div id="foto-preview" class="grid grid-cols-2 md:grid-cols-5 gap-3"></div>
            </div>
        </div>

        <div class="flex gap-3 justify-end">
            <a href="{{ url()->previous() }}" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-primary btn-lg">Publicar Anúncio</button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
const cepInput = document.querySelector('[data-cep-input]');
const cepLoading = document.getElementById('cep-loading');

function limparCep() {
    ['endereco', 'bairro', 'cidade', 'estado'].forEach(id => {
        const el = document.getElementById(id);
        if (el && !el.value) el.value = '';
    });
}

function preencherCep(dados) {
    document.getElementById('endereco').value = dados.logradouro || '';
    document.getElementById('bairro').value = dados.bairro || '';
    document.getElementById('cidade').value = dados.localidade || '';
    document.getElementById('estado').value = dados.uf || '';
    document.getElementById('numero')?.focus();
}

cepInput?.addEventListener('blur', async function() {
    const cep = this.value.replace(/\D/g, '');
    if (cep.length !== 8) return;

    cepLoading.classList.remove('hidden');
    this.disabled = true;

    try {
        const res = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const dados = await res.json();

        if (dados.erro) {
            limparCep();
            return;
        }

        preencherCep(dados);
    } catch {
        limparCep();
    } finally {
        cepLoading.classList.add('hidden');
        this.disabled = false;
        this.focus();
    }
});

cepInput?.addEventListener('input', function() {
    let v = this.value.replace(/\D/g, '');
    if (v.length > 5) v = v.slice(0, 5) + '-' + v.slice(5);
    this.value = v;
});

document.getElementById('tipo_negocio_id')?.addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    const el = document.getElementById('datas-temporada');
    if (opt?.dataset.slug === 'temporada') {
        el.classList.remove('hidden');
    } else {
        el.classList.add('hidden');
    }
});

let fotosArray = [];
const fotoInput = document.getElementById('foto-input');
const fotoUploadZone = document.getElementById('foto-upload-zone');
const fotoPreview = document.getElementById('foto-preview');
const fotoCounter = document.getElementById('foto-counter');
const fotoCount = document.getElementById('foto-count');

let dragIndex = null;

function atualizarPreview() {
    fotoPreview.innerHTML = '';
    fotoCounter.classList.remove('hidden');
    fotoCount.textContent = fotosArray.length;

    fotosArray.forEach((foto, index) => {
        const div = document.createElement('div');
        div.className = 'relative group aspect-square rounded-box overflow-hidden bg-base-300 cursor-grab active:cursor-grabbing';
        div.draggable = true;
        div.dataset.index = index;

        div.innerHTML = `
            <img src="${foto.url}" class="w-full h-full object-cover pointer-events-none" />
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors flex items-center justify-center gap-2">
                <button type="button" data-remover-foto="${index}"
                        class="btn btn-circle btn-error btn-sm opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="absolute top-1 left-1 badge badge-sm badge-ghost">${index + 1}</div>
            <div class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                </svg>
            </div>
        `;

        div.addEventListener('dragstart', (e) => {
            dragIndex = parseInt(div.dataset.index);
            e.dataTransfer.effectAllowed = 'move';
            div.classList.add('opacity-40');
        });

        div.addEventListener('dragend', () => {
            div.classList.remove('opacity-40');
            fotoPreview.querySelectorAll('.dragover').forEach(el => el.classList.remove('dragover', 'ring-2', 'ring-primary'));
            dragIndex = null;
        });

        div.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
        });

        div.addEventListener('dragenter', () => {
            if (parseInt(div.dataset.index) !== dragIndex) {
                div.classList.add('dragover', 'ring-2', 'ring-primary');
            }
        });

        div.addEventListener('dragleave', () => {
            div.classList.remove('dragover', 'ring-2', 'ring-primary');
        });

        div.addEventListener('drop', (e) => {
            e.preventDefault();
            div.classList.remove('dragover', 'ring-2', 'ring-primary');
            if (dragIndex === null) return;

            const targetIndex = parseInt(div.dataset.index);
            if (dragIndex === targetIndex) return;

            const [item] = fotosArray.splice(dragIndex, 1);
            fotosArray.splice(targetIndex, 0, item);
            atualizarPreview();
        });

        fotoPreview.appendChild(div);
    });

    fotosArray.length > 0
        ? fotoUploadZone.classList.replace('border-base-300', 'border-primary')
        : fotoUploadZone.classList.replace('border-primary', 'border-base-300');
}

fotoUploadZone.addEventListener('click', () => fotoInput.click());

fotoUploadZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    fotoUploadZone.classList.add('border-primary', 'bg-primary/5');
});

fotoUploadZone.addEventListener('dragleave', () => {
    fotoUploadZone.classList.remove('bg-primary/5');
});

fotoUploadZone.addEventListener('drop', (e) => {
    e.preventDefault();
    fotoUploadZone.classList.remove('bg-primary/5');
    adicionarFotos(e.dataTransfer.files);
});

fotoInput.addEventListener('change', () => {
    adicionarFotos(fotoInput.files);
    fotoInput.value = '';
});

function adicionarFotos(files) {
    Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;
        if (file.size > 5 * 1024 * 1024) return;

        const reader = new FileReader();
        reader.onload = (ev) => {
            fotosArray.push({ file, url: ev.target.result });
            atualizarPreview();
        };
        reader.readAsDataURL(file);
    });
}

fotoPreview.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-remover-foto]');
    if (!btn) return;

    const index = parseInt(btn.dataset.removerFoto);
    fotosArray.splice(index, 1);
    atualizarPreview();
});

document.querySelector('form').addEventListener('submit', function() {
    if (fotosArray.length === 0) return;

    const dt = new DataTransfer();
    fotosArray.forEach(f => dt.items.add(f.file));
    fotoInput.files = dt.files;
});
</script>
@endpush
