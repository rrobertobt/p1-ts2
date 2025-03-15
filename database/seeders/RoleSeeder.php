<?php

namespace Database\Seeders;

use Database\Factories\RoleFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    RoleFactory::new()->createMany(
      [
        [
          'id' => 1,
          'name' => 'Monitor',
          'description' => 'Usuario que puede crear y correr simulaciones'
        ],
        [
          'id' => 2,
          'name' => 'Supervisor',
          'description' => 'Usuario que puede ver las simulaciones de los monitores y generar reportes'
        ],
        [
          'id' => 3,
          'name' => 'Administrador',
          'description' => 'Usuario que puede manejar usuarios y roles y administrar calles'
        ],
      ]
    );
  }
}
