<?php

namespace App\Http\Controllers;

use App\Models\BloqueInterseccion;
use App\Models\DatoSimulacion;
use App\Models\DetalleSimulacion;
use App\Models\Interseccion;
use App\Models\SemaforoParametros;
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

    $simulacionesAnteriores = Simulacion::where('id_usuario', Auth::id())->get();


    return view('dashboard.monitor.simulation', [
      'intersecciones' => $interseccionesDisponibles,
      'tiposSentido' => $tiposSentido,
      'simulaciones' => $simulacionesAnteriores
    ]);
  }

  public function detalle(Request $request, $id)
  {
    $simulacion = Simulacion::with('interseccion')->find($id);
    $interseccion = Interseccion::with(['bloques.tipo_bloque'])->find($simulacion->id_interseccion);

    if (!$simulacion) {
      return redirect()->route('dashboard.monitor.simulacion');
    }

    // $bloquesInterseccion = BloqueInterseccion::where('id_interseccion', $simulacion->id_interseccion)->get();

    // $datosSimulacion = DatoSimulacion::where('id_simulacion', $simulacion->id)->get();

    // $vehiculos = Vehiculo::all();

    return view('dashboard.monitor.simulation-detail', [
      'simulacion' => $simulacion,
      'interseccion' => $interseccion,
      // 'bloquesInterseccion' => $bloquesInterseccion,
      // 'datosSimulacion' => $datosSimulacion,
      // 'vehiculos' => $vehiculos
    ]);
  }

  public function ejecutarSimulacion($idSimulacion)
  {
    // Obtener la simulación
    $simulacion = Simulacion::findOrFail($idSimulacion);

    // Obtener los bloques de intersección relacionados
    $bloques = BloqueInterseccion::where('id_interseccion', $simulacion->id_interseccion)->get();

    DB::beginTransaction();
    try {
      foreach ($bloques as $bloque) {
        // Obtener el semáforo de este bloque
        $semaforo = SemaforoParametros::where([
          'id_simulacion' => $idSimulacion,
          'id_bloque_interseccion' => $bloque->id
        ])->first();

        if (!$semaforo) {
          continue;
        }

        // Obtener los vehículos en el bloque
        $num_flujo = DetalleSimulacion::where([
          'id_simulacion' => $idSimulacion,
          'id_bloque_interseccion' => $bloque->id
        ])->count();

        if ($num_flujo == 0) {
          continue; // Si no hay vehículos, pasamos al siguiente bloque
        }

        // Obtener tiempo de cruce promedio
        $tiempo_promedio_cruce = DB::table('vehiculo')
          ->join('dato_simulacion', 'vehiculo.id', '=', 'dato_simulacion.id_vehiculo')
          ->where('dato_simulacion.id_bloque_interseccion', $bloque->id)
          ->where('dato_simulacion.id_simulacion', $idSimulacion)
          ->avg('vehiculo.tiempo_cruce');

        // Calcular la capacidad de paso por ronda
        $capacidad_paso = floor($semaforo->tiempo_paso / $tiempo_promedio_cruce);

        // Calcular rondas necesarias
        $num_rondas = ceil($num_flujo / $capacidad_paso);

        // Calcular el tiempo total de vaciado
        $tiempo_vaciado = $num_rondas * ($semaforo->tiempo_paso + $semaforo->tiempo_espera);

        // Guardar en DatoSimulacion
        DatoSimulacion::where([
          'id_simulacion' => $idSimulacion,
          'id_bloque_interseccion' => $bloque->id
        ])->update([
          'num_rondas' => $num_rondas,
          'num_flujo' => $num_flujo,
          'tiempo_vaciado' => $tiempo_vaciado
        ]);
      }

      DB::commit();
      // return response()->json(['success' => true, 'message' => 'Simulación ejecutada con éxito']);
      return redirect()->route('dashboard.monitor.simulacion.detail', ['id' => $idSimulacion])->with('message', 'Simulación ejecutada con éxito');
    } catch (\Exception $e) {
      DB::rollBack();
      // return response()->json(['success' => false, 'message' => 'Error en la simulación', 'error' => $e->getMessage()], 500);
      return redirect()->route('dashboard.monitor.simulacion.detail', ['id' => $idSimulacion])->with('error', 'Error en la simulación, intenta de nuevo');
    }
  }

  public function guardarSimulacion(Request $request)
  {
    $userId = Auth::id();

    $simulacion = new Simulacion();
    $simulacion->id_usuario = $userId;
    $simulacion->id_interseccion = $request->id_interseccion;
    $simulacion->modalidad = $request->modalidad_sim;
    $simulacion->estado = 'pendiente';
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

          // Crear el semáforo para este bloque
          $semaforoTiempoEspera = $request->input("tiempo_semaforo_rojo_$direccion", 0);
          $semaforoTiempoPaso = $request->input("tiempo_semaforo_verde_$direccion", 0);
          $semaforo = new SemaforoParametros();
          $semaforo->id_simulacion = $simulacion->id;
          $semaforo->id_bloque_interseccion = $bloqueInterseccion->id;
          $semaforo->tiempo_paso = $semaforoTiempoPaso;
          $semaforo->tiempo_espera = $semaforoTiempoEspera;
          $semaforo->save();
        }

        // antes tambien crear el semaforo_parametros correspondiente


        // Insertar datos de simulación en bloque para optimizar rendimiento
        if (!empty($detallesSimulacionInsert)) {
          DetalleSimulacion::insert($detallesSimulacionInsert);
        }

        DB::commit();
        // return response()->json(['success' => true, 'message' => 'Simulación cargada correctamente']);
        return redirect()->route('dashboard.monitor.simulacion.detail', ['id' => $simulacion->id])->with('message', 'Simulación cargada correctamente');
      } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('dashboard.monitor.simulacion')->with('error', 'Error en carga de simulación, intenta de nuevo');
      }
    } elseif ($modoSimulacion == 'random') {
      $this->generarVehiculosAleatorios($request, $simulacion);
      return redirect()->route('dashboard.monitor.simulacion.detail', ['id' => $simulacion->id])->with('message', 'Simulación aleatoria generada correctamente');
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

        // Crear el semáforo para este bloque
        $semaforoTiempoEspera = $request->input("tiempo_semaforo_rojo_$direccion", 0);
        $semaforoTiempoPaso = $request->input("tiempo_semaforo_verde_$direccion", 0);

        $semaforo = new SemaforoParametros();
        $semaforo->id_simulacion = $simulacion->id;
        $semaforo->id_bloque_interseccion = $bloqueInterseccion->id;
        $semaforo->tiempo_paso = $semaforoTiempoPaso;
        $semaforo->tiempo_espera = $semaforoTiempoEspera;
        $semaforo->save();
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
