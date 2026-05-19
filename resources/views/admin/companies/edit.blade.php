@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Editar Empresa</h1>
    <p class="text-base-content/60">Editando: {{ $company->nome_fantasia }}</p>
</div>

<div class="card bg-base-100 shadow-sm max-w-2xl">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.companies.update', $company) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label" for="razao_social">
                        <span class="label-text">Razão Social</span>
                    </label>
                    <input id="razao_social" type="text" name="razao_social" value="{{ old('razao_social', $company->razao_social) }}"
                           class="input input-bordered w-full @error('razao_social') input-error @enderror" required />
                    @error('razao_social')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label" for="nome_fantasia">
                        <span class="label-text">Nome Fantasia</span>
                    </label>
                    <input id="nome_fantasia" type="text" name="nome_fantasia" value="{{ old('nome_fantasia', $company->nome_fantasia) }}"
                           class="input input-bordered w-full @error('nome_fantasia') input-error @enderror" required />
                    @error('nome_fantasia')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label" for="cnpj">
                        <span class="label-text">CNPJ</span>
                    </label>
                    <input id="cnpj" type="text" name="cnpj" value="{{ old('cnpj', $company->cnpj) }}"
                           class="input input-bordered w-full @error('cnpj') input-error @enderror" required />
                    @error('cnpj')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label" for="plano">
                        <span class="label-text">Plano</span>
                    </label>
                    <select id="plano" name="plano" class="select select-bordered w-full">
                        <option value="gratuito" {{ old('plano', $company->plano) === 'gratuito' ? 'selected' : '' }}>Gratuito</option>
                        <option value="starter" {{ old('plano', $company->plano) === 'starter' ? 'selected' : '' }}>Starter</option>
                        <option value="pro" {{ old('plano', $company->plano) === 'pro' ? 'selected' : '' }}>Pro</option>
                        <option value="business" {{ old('plano', $company->plano) === 'business' ? 'selected' : '' }}>Business</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label" for="telefone">
                        <span class="label-text">Telefone</span>
                    </label>
                    <input id="telefone" type="text" name="telefone" value="{{ old('telefone', $company->telefone) }}"
                           class="input input-bordered w-full" />
                </div>

                <div class="form-control">
                    <label class="label" for="celular">
                        <span class="label-text">Celular</span>
                    </label>
                    <input id="celular" type="text" name="celular" value="{{ old('celular', $company->celular) }}"
                           class="input input-bordered w-full" />
                </div>

                <div class="form-control">
                    <label class="label" for="email">
                        <span class="label-text">E-mail</span>
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email', $company->email) }}"
                           class="input input-bordered w-full" />
                </div>

                <div class="form-control">
                    <label class="label" for="site">
                        <span class="label-text">Site</span>
                    </label>
                    <input id="site" type="url" name="site" value="{{ old('site', $company->site) }}"
                           class="input input-bordered w-full" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div class="form-control">
                    <label class="label" for="endereco">
                        <span class="label-text">Endereço</span>
                    </label>
                    <input id="endereco" type="text" name="endereco" value="{{ old('endereco', $company->endereco) }}"
                           class="input input-bordered w-full" />
                </div>

                <div class="form-control">
                    <label class="label" for="bairro">
                        <span class="label-text">Bairro</span>
                    </label>
                    <input id="bairro" type="text" name="bairro" value="{{ old('bairro', $company->bairro) }}"
                           class="input input-bordered w-full" />
                </div>

                <div class="form-control">
                    <label class="label" for="cidade">
                        <span class="label-text">Cidade</span>
                    </label>
                    <input id="cidade" type="text" name="cidade" value="{{ old('cidade', $company->cidade) }}"
                           class="input input-bordered w-full" />
                </div>

                <div class="form-control">
                    <label class="label" for="estado">
                        <span class="label-text">Estado</span>
                    </label>
                    <input id="estado" type="text" name="estado" value="{{ old('estado', $company->estado) }}"
                           class="input input-bordered w-full" maxlength="2" />
                </div>

                <div class="form-control">
                    <label class="label" for="cep">
                        <span class="label-text">CEP</span>
                    </label>
                    <input id="cep" type="text" name="cep" value="{{ old('cep', $company->cep) }}"
                           class="input input-bordered w-full" />
                </div>

                <div class="form-control">
                    <label class="label" for="ativo">
                        <span class="label-text">Status</span>
                    </label>
                    <select id="ativo" name="ativo" class="select select-bordered w-full">
                        <option value="1" {{ old('ativo', $company->ativo) ? 'selected' : '' }}>Ativo</option>
                        <option value="0" {{ old('ativo', !$company->ativo) ? '' : '' }}>Inativo</option>
                    </select>
                </div>
            </div>

            <div class="form-control mt-4">
                <label class="label" for="descricao">
                    <span class="label-text">Descrição</span>
                </label>
                <textarea id="descricao" name="descricao" rows="3"
                          class="textarea textarea-bordered w-full">{{ old('descricao', $company->descricao) }}</textarea>
            </div>

            <div class="flex gap-2 mt-6">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('admin.companies.index') }}" class="btn btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
