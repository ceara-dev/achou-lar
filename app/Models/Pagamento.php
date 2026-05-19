<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $fillable = [
        'contrato_id',
        'data_vencimento',
        'data_pagamento',
        'valor',
        'atrasado',
        'agua',
        'energia',
        'internet',
        'observacao',
    ];

    protected function casts(): array
    {
        return [
            'data_vencimento' => 'date',
            'data_pagamento' => 'date',
            'valor' => 'decimal:2',
            'atrasado' => 'boolean',
            'agua' => 'decimal:2',
            'energia' => 'decimal:2',
            'internet' => 'decimal:2',
        ];
    }

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
