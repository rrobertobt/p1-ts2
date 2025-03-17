<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloque extends Model
{
    /** @use HasFactory<\Database\Factories\BloqueFactory> */
    use HasFactory;

    protected $table = 'bloque';

    public function tipo_bloque()
    {
        return $this->belongsTo(TipoBloque::class, 'id_tipo');
    }
}
