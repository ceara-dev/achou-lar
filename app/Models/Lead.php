<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Lead extends Model implements AuditableContract
{
    use Auditable;

    protected $fillable = [
        'imovel_id',
        'user_id',
        'nome',
        'email',
        'telefone',
        'mensagem',
        'tipo_proposta',
        'valor_proposta',
        'lido',
    ];

    protected function casts(): array
    {
        return [
            'lido' => 'boolean',
            'valor_proposta' => 'decimal:2',
        ];
    }

    public function imovel()
    {
        return $this->belongsTo(Imovel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeNaoLido($query)
    {
        return $query->where('lido', false);
    }
}
