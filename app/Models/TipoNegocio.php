<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class TipoNegocio extends Model implements AuditableContract
{
    use Auditable;

    protected $fillable = ['nome', 'slug', 'descricao'];

    public function imoveis()
    {
        return $this->hasMany(Imovel::class);
    }
}
