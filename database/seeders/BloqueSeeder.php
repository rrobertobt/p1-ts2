<?php

namespace Database\Seeders;

use App\Models\BloqueInterseccion;
use Database\Factories\BloqueFactory;
use Database\Factories\InterseccionFactory;
use Database\Factories\TipoBloqueFactory;
use Database\Factories\TipoSentidoFactory;
use Illuminate\Database\Seeder;

class BloqueSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {

      TipoBloqueFactory::new()->createMany([
          [
            'id' => 1,
            'nombre' => 'Calle',
          ],
          [
            'id' => 2,
            'nombre' => 'Avenida',
          ],
          [
            'id' => 3,
            'nombre' => 'Diagonal',
          ],
          [
            'id' => 4,
            'nombre' => 'Calzada',
          ]
      ]);

    TipoSentidoFactory::new()->createMany([
      [
        'id' => 1,
        'nombre' => 'Norte a Sur',
      ],
      [
        'id' => 2,
        'nombre' => 'Sur a Norte',
      ],
      [
        'id' => 3,
        'nombre' => 'Este a Oeste',
      ],
      [
        'id' => 4,
        'nombre' => 'Oeste a Este',
      ],
    ]);

    // crear 4 bloques

    BloqueFactory::new()->createMany([
      [
        'id' => 1,
        'nombre' => '7 Calle',
        'numero' => '7',
        'id_tipo' => 1,
      ],
      [
        'id' => 2,
        'nombre' => '10 Avenida',
        'numero' => '10',
        'id_tipo' => 2,
      ],
      // ...
      [
        'id' => 3,
        'nombre' => '9 Calle',
        'numero' => '9',
        'id_tipo' => 1,
      ],
      [
        'id' => 4,
        'nombre' => 'Calzada San Juan',
        'numero' => null,
        'id_tipo' => 4,
      ]
    ]);

    // Crear 2 intersecciones
    InterseccionFactory::new()->createMany([
      [
        'id' => 1,
        'nombre' => '7 Calle y 10 Avenida',
      ],
      [
        'id' => 2,
        'nombre' => '9 Calle y Calzada San Juan',
      ],
    ]);

    // Relacionar bloques con intersecciones
    // primera interseccion
    // interseccion id 1, bloque id 1, sentido norte a sur
    BloqueInterseccion::create([
      'id_interseccion' => 1,
      'id_bloque' => 1,
      'id_tipo_sentido' => 1,
    ]);

    // interseccion id 1, bloque id 1, sentido sur a norte
    BloqueInterseccion::create([
      'id_interseccion' => 1,
      'id_bloque' => 1,
      'id_tipo_sentido' => 2,
    ]);

    // interseccion id 1, bloque id 2, sentido este a oeste
    BloqueInterseccion::create([
      'id_interseccion' => 1,
      'id_bloque' => 2,
      'id_tipo_sentido' => 3,
    ]);


    // interseccion id 1, bloque id 2, sentido oeste a este
    BloqueInterseccion::create([
      'id_interseccion' => 1,
      'id_bloque' => 2,
      'id_tipo_sentido' => 4,
    ]);


    // segunda interseccion
    // interseccion id 2, bloque id 3, sentido norte a sur
    BloqueInterseccion::create([
      'id_interseccion' => 2,
      'id_bloque' => 3,
      'id_tipo_sentido' => 1,
    ]);

    // interseccion id 2, bloque id 3, sentido sur a norte
    BloqueInterseccion::create([
      'id_interseccion' => 2,
      'id_bloque' => 3,
      'id_tipo_sentido' => 2,
    ]);

    // interseccion id 2, bloque id 4, sentido este a oeste
    BloqueInterseccion::create([
      'id_interseccion' => 2,
      'id_bloque' => 4,
      'id_tipo_sentido' => 3,
    ]);

    // interseccion id 2, bloque id 4, sentido oeste a este
    BloqueInterseccion::create([
      'id_interseccion' => 2,
      'id_bloque' => 4,
      'id_tipo_sentido' => 4,
    ]);

  }
}
