<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleSimulacion extends Model
{
    /** @use HasFactory<\Database\Factories\DetalleSimulacionFactory> */
    use HasFactory;

    protected $table = 'detalle_simulacion';

    protected $fillable = [
        'id_simulacion',
        'id_vehiculo',
        'id_bloque_interseccion',
        'orden',
    ];
}
