<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoBloque extends Model
{
    /** @use HasFactory<\Database\Factories\TipoBloqueFactory> */
    use HasFactory;

    protected $table = 'tipo_bloque';
}
