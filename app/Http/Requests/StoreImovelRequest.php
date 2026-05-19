<?php

namespace App\Http\Requests;

use App\Models\TipoNegocio;
use Illuminate\Foundation\Http\FormRequest;

class StoreImovelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_negocio_id' => 'required|exists:tipo_negocios,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'regras' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'valor_condominio' => 'nullable|numeric|min:0',
            'iptu' => 'nullable|numeric|min:0',
            'inclui_agua' => 'boolean',
            'inclui_energia' => 'boolean',
            'inclui_internet' => 'boolean',
            'area' => 'nullable|numeric|min:0',
            'quartos' => 'nullable|integer|min:0',
            'banheiros' => 'nullable|integer|min:0',
            'cozinhas' => 'nullable|integer|min:0',
            'vagas' => 'nullable|integer|min:0',
            'tipo_residencia' => 'nullable|string|in:residencial,comercial',
            'endereco' => 'required|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
            'cep' => 'nullable|string|max:9',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ];

        if ($this->hasFile('fotos') || $this->has('fotos')) {
            $rules['fotos'] = 'array';
            $rules['fotos.*'] = 'image|mimes:jpeg,png,jpg,webp|max:5120';
        }

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $fotos = $this->file('fotos');
            if ($fotos && count($fotos) > 0 && count($fotos) < 10) {
                $validator->errors()->add(
                    'fotos',
                    'Se enviar fotos, o mínimo é 10 fotos. Enviadas: ' . count($fotos)
                );
            }

            $tipo = TipoNegocio::find($this->input('tipo_negocio_id'));
            if ($tipo && $tipo->slug === 'temporada') {
                if (!$this->filled('data_inicio')) {
                    $validator->errors()->add('data_inicio', 'Para Temporada, informe a data de início.');
                }
                if (!$this->filled('data_fim')) {
                    $validator->errors()->add('data_fim', 'Para Temporada, informe a data de fim.');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'data_fim.after_or_equal' => 'A data de fim deve ser igual ou posterior à data de início.',
            'fotos.*.image' => 'Cada arquivo deve ser uma imagem.',
            'fotos.*.mimes' => 'As fotos devem ser JPEG, PNG ou WebP.',
            'fotos.*.max' => 'Cada foto deve ter no máximo 5MB.',
        ];
    }
}
