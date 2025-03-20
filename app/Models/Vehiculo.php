<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    /** @use HasFactory<\Database\Factories\VehiculoFactory> */
    use HasFactory;

    protected $table = 'vehiculo';

    protected $fillable = [
        'id_tipo_vehiculo',
        'tiempo_reaccion',
        'tiempo_cruce',
    ];
}
