<?php

namespace App\Models;

use Database\Factories\ImovelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Imovel extends Model implements AuditableContract
{
    /** @use HasFactory<ImovelFactory> */
    use HasFactory, SoftDeletes, Auditable;

    protected $fillable = [
        'user_id',
        'categoria_id',
        'tipo_negocio_id',
        'titulo',
        'descricao',
        'preco',
        'valor_condominio',
        'iptu',
        'inclui_agua',
        'inclui_energia',
        'inclui_internet',
        'regras',
        'area',
        'quartos',
        'banheiros',
        'cozinhas',
        'vagas',
        'tipo_residencia',
        'endereco',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'latitude',
        'longitude',
        'destaque',
        'aprovado',
        'status',
        'views',
        'data_inicio',
        'data_fim',
    ];

    protected function casts(): array
    {
        return [
            'preco' => 'decimal:2',
            'area' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'destaque' => 'boolean',
            'aprovado' => 'boolean',
            'inclui_agua' => 'boolean',
            'inclui_energia' => 'boolean',
            'inclui_internet' => 'boolean',
            'views' => 'integer',
            'data_inicio' => 'date',
            'data_fim' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function tipoNegocio()
    {
        return $this->belongsTo(TipoNegocio::class);
    }

    public function fotos()
    {
        return $this->hasMany(Foto::class)->orderBy('ordem');
    }

    public function fotoCapa()
    {
        return $this->hasOne(Foto::class)->where('is_capa', true);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    public function contratos()
    {
        return $this->hasMany(Contrato::class);
    }

    public function favoritadoPor(User $user)
    {
        return $this->favoritos()->where('user_id', $user->id)->exists();
    }

    public function scopeAtivo($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAprovado($query)
    {
        return $query->where('aprovado', true);
    }

    public function scopeEmDestaque($query)
    {
        return $query->where('destaque', true);
    }

    public function scopeDaCidade($query, $cidade)
    {
        return $query->where('cidade', $cidade);
    }

    public function scopePorPreco($query, $min = null, $max = null)
    {
        if ($min) $query->where('preco', '>=', $min);
        if ($max) $query->where('preco', '<=', $max);
        return $query;
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function getPrecoFormatadoAttribute(): string
    {
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }

    public function getAreaFormatadaAttribute(): string
    {
        return number_format($this->area, 2, ',', '.') . ' m²';
    }
}
