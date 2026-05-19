<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Company extends Model implements AuditableContract
{
    use Auditable;

    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'telefone',
        'celular',
        'email',
        'site',
        'endereco',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'logo',
        'descricao',
        'plano',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
        ];
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function imoveis()
    {
        return $this->hasManyThrough(Imovel::class, User::class);
    }

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }
}
