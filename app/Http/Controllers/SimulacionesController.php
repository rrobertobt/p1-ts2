<?php

namespace App\Http\Controllers;

use App\Models\BloqueInterseccion;
use App\Models\DatoSimulacion;
use App\Models\DetalleSimulacion;
use App\Models\Interseccion;
use App\Models\Simulacion;
use App\Models\TipoSentido;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SimulacionesController extends Controller
{
  //
  public function simulacion(Request $request)
  {
    $interseccionesDisponibles = Interseccion::all();

    $tiposSentido = TipoSentido::all();


    return view('dashboard.monitor.simulation', [
      'intersecciones' => $interseccionesDisponibles,
      'tiposSentido' => $tiposSentido
    ]);
  }

  public function guardarSimulacion(Request $request)
  {
    $userId = Auth::id();

    $simulacion = new Simulacion();
    $simulacion->id_usuario = $userId;
    $simulacion->id_interseccion = $request->id_interseccion;
    $modoSimulacion = $request->modalidad_sim;
    $simulacion->save();

    $direcciones = ['ns', 'sn', 'eo', 'oe'];

    $detallesSimulacionInsert = [];

    if ($modoSimulacion == 'archivo') {
      $file = $request->file('archivo');
      $json = json_decode(file_get_contents($file), true);

      DB::beginTransaction();
      try {
        foreach ($direcciones as $direccion) {
          if (!isset($json[$direccion]['vehiculos'])) {
            continue;
          }

          $id_tipo_sentido = $json[$direccion]['id_tipo_sentido'] ?? null;

          foreach ($json[$direccion]['vehiculos'] as $vehiculo) {
            // Insertar vehículo y obtener su ID
            $vehiculoNuevo = Vehiculo::create([
              'id_tipo_vehiculo' => $vehiculo['id_tipo_vehiculo'],
              'tiempo_reaccion' => $vehiculo['tiempo_reaccion'],
              'tiempo_cruce' => $vehiculo['tiempo_cruce']
            ]);

            // Buscar el bloque de intersección correspondiente
            $bloqueInterseccion = BloqueInterseccion::where([
              'id_interseccion' => $simulacion->id_interseccion,
              'id_tipo_sentido' => $id_tipo_sentido
            ])->first();

            if ($bloqueInterseccion) {
              $detallesSimulacionInsert[] = [
                'id_simulacion' => $simulacion->id,
                'id_bloque_interseccion' => $bloqueInterseccion->id,
                'id_vehiculo' => $vehiculoNuevo->id
              ];
            }
          }
        }

        // Insertar datos de simulación en bloque para optimizar rendimiento
        if (!empty($detallesSimulacionInsert)) {
          DetalleSimulacion::insert($detallesSimulacionInsert);
        }

        DB::commit();
        return response()->json(['success' => true, 'message' => 'Simulación cargada correctamente']);
      } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => 'Error al procesar la simulación', 'error' => $e->getMessage()], 500);
      }
    } elseif ($modoSimulacion == 'random') {
      $this->generarVehiculosAleatorios($request, $simulacion);
      return response()->json(['success' => true, 'message' => 'Simulación aleatoria generada correctamente']);
    }
  }

  private function generarVehiculosAleatorios(Request $request, Simulacion $simulacion)
  {
    // Parámetros de vehículos según tipo
    $paramVehiculos = [
      1 => ['tiempo_reaccion' => 1.5, 'tiempo_cruce' => 3], // Auto
      2 => ['tiempo_reaccion' => 1.5, 'tiempo_cruce' => 2], // Moto
      3 => ['tiempo_reaccion' => 2.0, 'tiempo_cruce' => 4], // Camión
      4 => ['tiempo_reaccion' => 2.0, 'tiempo_cruce' => 4]  // Bus
    ];

    // Direcciones permitidas
    $direcciones = ['ns', 'sn', 'eo', 'oe'];

    $detallesSimulacionInsert = [];

    DB::beginTransaction();
    try {
      error_log('Generando vehículos aleatorios...');
      foreach ($direcciones as $direccion) {
        // Leer cantidad de vehículos del formulario
        $cantidad = $request->input("cantidad_vehiculos_$direccion", 0);
        if ($cantidad <= 0) {
          continue;
        }

        // Obtener `id_tipo_sentido` del JSON (si existe) o asignar manualmente
        $id_tipo_sentido = $request->input("id_tipo_sentido_$direccion");
        error_log("ID Tipo Sentido: $id_tipo_sentido");

        for ($i = 0; $i < $cantidad; $i++) {
          // Elegir un tipo de vehículo aleatorio
          $tipoVehiculo = array_rand($paramVehiculos);

          // Agregar variabilidad aleatoria en tiempos (±10%)
          $tiempoReaccion = round($paramVehiculos[$tipoVehiculo]['tiempo_reaccion'] * (0.9 + mt_rand(0, 20) / 100), 2);
          $tiempoCruce = round($paramVehiculos[$tipoVehiculo]['tiempo_cruce'] * (0.9 + mt_rand(0, 20) / 100), 2);

          // Crear el vehículo
          $vehiculoNuevo = Vehiculo::create([
            'id_tipo_vehiculo' => $tipoVehiculo,
            'tiempo_reaccion' => $tiempoReaccion,
            'tiempo_cruce' => $tiempoCruce
          ]);

          // Buscar el bloque de intersección correcto
          $bloqueInterseccion = BloqueInterseccion::where([
            'id_interseccion' => $simulacion->id_interseccion,
            'id_tipo_sentido' => $id_tipo_sentido
          ])->first();

          if ($bloqueInterseccion) {
            $detallesSimulacionInsert[] = [
              'id_simulacion' => $simulacion->id,
              'id_bloque_interseccion' => $bloqueInterseccion->id,
              'id_vehiculo' => $vehiculoNuevo->id
            ];
          }
        }
      }

      // Inserción masiva en `DatoSimulacion`
      if (!empty($detallesSimulacionInsert)) {
        DetalleSimulacion::insert($detallesSimulacionInsert);
      }

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json(['success' => false, 'message' => 'Error en generación aleatoria', 'error' => $e->getMessage()], 500);
    }
  }
}
