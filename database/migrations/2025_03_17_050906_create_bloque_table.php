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
    

    Schema::create('tipo_sentido', function (Blueprint $table) {
      $table->id();
      $table->string('nombre');
      $table->timestamps();
    });

    Schema::create('tipo_bloque', function (Blueprint $table) {
      $table->id();
      $table->string('nombre');
      $table->timestamps();
    });

    Schema::create('bloque', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_tipo')->constrained('tipo_bloque')->onDelete('cascade');
      $table->string('nombre')->unique();
      $table->string('numero')->nullable();
      $table->timestamps();
    });

    Schema::create('interseccion', function (Blueprint $table) {
      $table->id();
      $table->string('nombre');
      $table->timestamps();
      $table->foreignId('id_bloque_vertical')
        ->constrained('bloque')
        ->onDelete('cascade');
      $table->foreignId('id_bloque_horizontal')
        ->constrained('bloque')
        ->onDelete('cascade');
    });

    Schema::create('bloque_interseccion', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_interseccion')
        ->constrained('interseccion')
        ->onDelete('cascade');

      $table->foreignId('id_bloque')
        ->constrained('bloque')
        ->onDelete('cascade');

      $table->foreignId('id_tipo_sentido')
        ->constrained('tipo_sentido')
        ->onDelete('restrict');


      $table->unique(['id_interseccion', 'id_tipo_sentido']);

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('bloque');
    Schema::dropIfExists('bloque_interseccion');
    Schema::dropIfExists('tipo_bloque');
    Schema::dropIfExists('tipo_sentido');
    Schema::dropIfExists('interseccion');
  }
};
