<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatoSimulacion extends Model
{
    /** @use HasFactory<\Database\Factories\DatoSimulacionFactory> */
    use HasFactory;

    protected $table = 'dato_simulacion';
}
