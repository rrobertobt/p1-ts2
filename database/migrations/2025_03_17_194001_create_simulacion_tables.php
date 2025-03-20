<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('simulacion', function (Blueprint $table) {
      $table->id();
      $table->dateTime('fecha_hora_inicio')->useCurrent();
      $table->dateTime('fecha_hora_fin')->nullable();
      $table->foreignId('id_usuario')->constrained('users');
      $table->foreignId('id_interseccion')->constrained('interseccion');
      $table->integer('tiempo_vaciado')->nullable();
      $table->timestamps();
    });

    Schema::create('tipo_vehiculo', function (Blueprint $table) {
      $table->id();
      $table->string('nombre');
      $table->timestamps();
    });
    Schema::create('vehiculo', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_tipo_vehiculo')->constrained('tipo_vehiculo');
      // $table->integer('tiempo_reaccion');
      // $table->integer('tiempo_cruce');
      // change to decimal
      $table->decimal('tiempo_reaccion', 8, 2);
      $table->decimal('tiempo_cruce', 8, 2);
      $table->timestamps();
    });

    Schema::create('detalle_simulacion', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_simulacion')->constrained('simulacion');
      $table->foreignId('id_vehiculo')->constrained('vehiculo');
      $table->foreignId('id_bloque_interseccion')->constrained('bloque_interseccion');
      $table->integer('orden')->nullable();

      $table->timestamps();
    });

    Schema::create('dato_simulacion', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_simulacion')->constrained('simulacion');
      $table->foreignId('id_bloque_interseccion')->constrained('bloque_interseccion');
      $table->integer('num_rondas');
      $table->integer('num_flujo');
      $table->integer('tiempo_vaciado');
      $table->timestamps();
    });

    Schema::create('semaforo_parametros', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_simulacion')->constrained('simulacion');
      $table->foreignId('id_bloque_interseccion')->constrained('bloque_interseccion');
      $table->integer('tiempo_paso');
      $table->integer('tiempo_precaucion');
      $table->integer('tiempo_espera');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('simulacion');
  }
};
