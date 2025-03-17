<?php

namespace Database\Seeders;

use App\Models\Bloque;
use App\Models\BloqueInterseccion;
use App\Models\Interseccion;
use App\Models\TipoBloque;
use App\Models\TipoSentido;
use Database\Factories\TipoBloqueFactory;
use Illuminate\Database\Seeder;

class BloqueSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $tiposBloque = ['Calle', 'Avenida', 'Diagonal'];

    foreach ($tiposBloque as $tipoBloque) {
      TipoBloqueFactory::new()->create([
        'nombre' => $tipoBloque,
      ]);
    }

    $sentidos = ['Norte a Sur', 'Sur a Norte', 'Este a Oeste', 'Oeste a Este'];
    foreach ($sentidos as $sentido) {
      TipoSentido::firstOrCreate(['nombre' => $sentido]);
    }

    // Crear dos intersecciones
    for ($i = 0; $i < 2; $i++) {
      $interseccion = Interseccion::factory()->create();

      // Crear 2 bloques, uno con número y otro sin número
      $bloque1 = Bloque::factory()->create();
      $bloque2 = Bloque::factory()->create();

      // Relacionarlos con la intersección
      foreach (TipoSentido::all() as $sentido) {
        BloqueInterseccion::factory()->create([
          'id_interseccion' => $interseccion->id,
          'id_bloque' => $i % 2 == 0 ? $bloque1->id : $bloque2->id,
          'id_tipo_sentido' => $sentido->id,
        ]);
      }
    }
  }
}
