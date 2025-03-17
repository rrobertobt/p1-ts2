<?php

namespace Database\Factories;

use App\Models\TipoBloque;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bloque>
 */
class BloqueFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    $numero = $this->faker->boolean(70) ? $this->faker->randomDigitNotZero() : null;
    $nombreBase = $this->faker->streetName;
    $tipoBloque = TipoBloque::inRandomOrder()->first()->id ?? 1; // Elegir tipo aleatorio o default 1

    return [
      'numero' => $numero,
      'nombre' => $numero ? "$numero $nombreBase" : $nombreBase,
      'id_tipo' => $tipoBloque,
    ];
  }
}
