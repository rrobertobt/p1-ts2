<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interseccion extends Model
{
  /** @use HasFactory<\Database\Factories\InterseccionFactory> */
  use HasFactory;

  protected $table = 'interseccion';

  public function bloques()
  {
    // return $this->belongsToMany(Bloque::class, 'bloque_interseccion', 'id_interseccion', 'id_bloque')
    // ->withPivot('id_tipo_sentido');
    return $this->belongsToMany(Bloque::class, 'bloque_interseccion', 'id_interseccion', 'id_bloque')
    ->using(BloqueInterseccion::class)->withPivot(['id_tipo_sentido']);
  }
}
