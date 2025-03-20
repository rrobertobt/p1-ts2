<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\RoleFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      RoleFactory::new()->createMany(
        [
          [
            'id' => 1,
            'name' => 'Monitor',
            'description' => 'Usuario que puede crear y correr simulaciones',
            'slug' => 'monitor'
          ],
          [
            'id' => 2,
            'name' => 'Supervisor',
            'description' => 'Usuario que puede ver las simulaciones de los monitores y generar reportes',
            'slug' => 'supervisor'
          ],
          [
            'id' => 3,
            'name' => 'Administrador',
            'description' => 'Usuario que puede manejar usuarios y roles y administrar calles',
            'slug' => 'admin'
          ],
        ]
      );


        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Roberto Administrador',
            'email' => 'radmin@muni.gt',
            'password' => 'password',
            'role_id' => 3,

        ]);
        User::factory()->create([
            'name' => 'Roberto Monitor',
            'email' => 'rmonitor@muni.gt',
            'password' => 'password',
            'role_id' => 1,
        ]);
        User::factory()->create([
            'name' => 'Roberto Supervisor',
            'email' => 'rsup@muni.gt',
            'password' => 'password',
            'role_id' => 2,
        ]);
        User::factory()->create([
            'name' => 'Monitor Inactivo',
            'email' => 'rsupin@muni.gt',
            'password' => 'password',
            'role_id' => 1,
            'is_active' => false,
        ]);

        $this->call([
            BloqueSeeder::class,
            SimulacionesSeeder::class,
        ]);
    }
}
