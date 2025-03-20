<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simulacion extends Model
{
    /** @use HasFactory<\Database\Factories\TipoSentidoFactory> */
    use HasFactory;

    protected $table = 'simulacion';

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function interseccion()
    {
        return $this->belongsTo(Interseccion::class, 'id_interseccion');
    }
}
