<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Foto extends Model implements AuditableContract
{
    use Auditable;

    protected $fillable = ['imovel_id', 'caminho', 'ordem', 'is_capa'];

    protected function casts(): array
    {
        return [
            'is_capa' => 'boolean',
            'ordem' => 'integer',
        ];
    }

    public function imovel()
    {
        return $this->belongsTo(Imovel::class);
    }
}
