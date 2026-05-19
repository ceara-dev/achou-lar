<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $fillable = [
        'imovel_id',
        'user_id',
        'tipo',
        'acao',
        'valor',
        'data',
        'inicio',
        'prazo',
        'arquivo',
    ];

    protected function casts(): array
    {
        return [
            'valor' => 'decimal:2',
            'data' => 'date',
            'inicio' => 'date',
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

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }
}
