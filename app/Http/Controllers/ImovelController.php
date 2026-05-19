<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImovelRequest;
use App\Models\Categoria;
use App\Models\Foto;
use App\Models\Imovel;
use App\Models\TipoNegocio;
use Illuminate\Http\Request;
use Inertia\Inertia;
use OwenIt\Auditing\Models\Audit;

class ImovelController extends Controller
{
    public function index()
    {
        $imoveis = Imovel::where('user_id', auth()->id())
            ->with(['categoria', 'tipoNegocio', 'fotoCapa', 'fotos'])
            ->latest()
            ->paginate(12);

        return Inertia::render('Imovel/Index', compact('imoveis'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $tipos = TipoNegocio::all();
        return Inertia::render('Imovel/Create', compact('categorias', 'tipos'));
    }

    public function store(StoreImovelRequest $request)
    {
        $endereco = $request->endereco;
        if ($request->filled('numero')) {
            $endereco .= ', ' . $request->numero;
        }

        $imovel = Imovel::create([
            'user_id' => auth()->id(),
            'categoria_id' => $request->categoria_id,
            'tipo_negocio_id' => $request->tipo_negocio_id,
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'regras' => $request->regras,
            'preco' => $request->preco,
            'valor_condominio' => $request->valor_condominio,
            'iptu' => $request->iptu,
            'inclui_agua' => $request->boolean('inclui_agua'),
            'inclui_energia' => $request->boolean('inclui_energia'),
            'inclui_internet' => $request->boolean('inclui_internet'),
            'area' => $request->area,
            'quartos' => $request->quartos,
            'banheiros' => $request->banheiros,
            'cozinhas' => $request->cozinhas,
            'vagas' => $request->vagas,
            'tipo_residencia' => $request->tipo_residencia,
            'endereco' => $endereco,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'cep' => $request->cep,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
        ]);

        $fotos = $request->allFiles()['fotos'] ?? [];
        if (!is_array($fotos)) {
            $fotos = [$fotos];
        }
        foreach ($fotos as $ordem => $foto) {
            if ($foto && $foto->isValid()) {
                $caminho = $foto->store('imoveis/' . $imovel->id, 'public');
                Foto::create([
                    'imovel_id' => $imovel->id,
                    'caminho' => $caminho,
                    'ordem' => $ordem,
                    'is_capa' => $ordem === 0,
                ]);
            }
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Imóvel anunciado com sucesso!');
    }

    public function edit(Imovel $imovel)
    {
        $imovel->load('fotos');
        $categorias = Categoria::all();
        $tipos = TipoNegocio::all();
        return Inertia::render('Admin/Imoveis/Edit', compact('imovel', 'categorias', 'tipos'));
    }

    public function update(Request $request, Imovel $imovel)
    {
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_negocio_id' => 'required|exists:tipo_negocios,id',
            'numero' => 'nullable|string|max:20',
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
        ]);

        $endereco = $request->endereco;
        if ($request->filled('numero')) {
            $endereco .= ', ' . $request->numero;
        }

        $imovel->update(array_merge($validated, ['endereco' => $endereco]));

        $fotos = $request->allFiles()['fotos'] ?? [];
        if (!is_array($fotos)) {
            $fotos = [$fotos];
        }
        $ultimaOrdem = $imovel->fotos()->max('ordem') ?? -1;
        foreach ($fotos as $ordem => $foto) {
            if ($foto && $foto->isValid()) {
                $caminho = $foto->store('imoveis/' . $imovel->id, 'public');
                Foto::create([
                    'imovel_id' => $imovel->id,
                    'caminho' => $caminho,
                    'ordem' => $ultimaOrdem + 1 + $ordem,
                    'is_capa' => false,
                ]);
            }
        }

        return redirect()->route('admin.imoveis.index')
            ->with('success', 'Imóvel atualizado com sucesso.');
    }

    public function destroy(Imovel $imovel)
    {
        $imovel->delete();

        return redirect()->route('admin.imoveis.index')
            ->with('success', 'Imóvel excluído com sucesso.');
    }

    public function show(Imovel $imovel)
    {
        $imovel->load(['categoria', 'tipoNegocio', 'fotos', 'user', 'documentos', 'contratos.user', 'contratos.pagamentos']);

        $audits = Audit::where('auditable_type', Imovel::class)
            ->where('auditable_id', $imovel->id)
            ->with('user')
            ->latest()
            ->get();

        $users = \App\Models\User::select('id', 'name', 'email')->orderBy('name')->get();

        return Inertia::render('Admin/Imoveis/Show', [
            'imovel' => $imovel,
            'audits' => $audits,
            'users' => $users,
        ]);
    }
}
