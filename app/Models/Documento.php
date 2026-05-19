<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = [
        'imovel_id',
        'titulo',
        'descricao',
        'arquivo',
    ];

    public function imovel()
    {
        return $this->belongsTo(Imovel::class);
    }
}
