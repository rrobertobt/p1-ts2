<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloqueInterseccion extends Model
{
    /** @use HasFactory<\Database\Factories\BloqueInterseccionFactory> */
    use HasFactory;

    protected $table = 'bloque_interseccion';
}
