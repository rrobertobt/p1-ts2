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

    public function intersecciones()
    {
        // return $this->belongsToMany(Interseccion::class, 'bloque_interseccion', 'id_bloque', 'id_interseccion')
        //             ->withPivot('id_tipo_sentido');  
        return $this->belongsToMany(Interseccion::class, 'bloque_interseccion', 'id_bloque', 'id_interseccion')
                    ->using(BloqueInterseccion::class)
                    ->withPivot(['id_tipo_sentido']);  
    }
}
