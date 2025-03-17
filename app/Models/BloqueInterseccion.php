<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BloqueInterseccion extends Pivot
{
    /** @use HasFactory<\Database\Factories\BloqueInterseccionFactory> */
    use HasFactory;

    protected $table = 'bloque_interseccion';

    public function tipo_sentido(): BelongsTo
    {
        return $this->belongsTo(TipoSentido::class, 'id_tipo_sentido');
    }

}
