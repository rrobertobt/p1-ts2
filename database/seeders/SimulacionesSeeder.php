<?php

namespace Database\Seeders;

use App\Models\TipoVehiculo;
use Illuminate\Database\Seeder;

class SimulacionesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        TipoVehiculo::factory()->createMany([
            [
                'id' => 1,
                'nombre' => 'Automóvil',
            ],
            [
                'id' => 2,
                'nombre' => 'Motocicleta',
            ],
            [
                'id' => 3,
                'nombre' => 'Camión',
            ],
            [
                'id' => 4,
                'nombre' => 'Bus',
            ]
        ]);
    }
}
