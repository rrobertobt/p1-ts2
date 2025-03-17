<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSentido extends Model
{
    /** @use HasFactory<\Database\Factories\TipoSentidoFactory> */
    use HasFactory;

    protected $table = 'tipo_sentido';

    public function bloqueIntersecciones()
    {
      return $this->hasMany(BloqueInterseccion::class, 'id_tipo_sentido');
    }
}
