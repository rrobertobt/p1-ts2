<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemaforoParametros extends Model
{
    /** @use HasFactory<\Database\Factories\SemaforoParametrosFactory> */
    use HasFactory;

    protected $table = 'semaforo_parametros';
}
