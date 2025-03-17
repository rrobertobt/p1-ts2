<?php

namespace App\Http\Controllers;

use App\Models\Interseccion;
use Illuminate\Http\Request;

class SimulacionesController extends Controller
{
  //
  public function simulacion(Request $request)
  {
    $interseccionesDisponibles = Interseccion::all();


    return view('dashboard.monitor.simulation', [
      'intersecciones' => $interseccionesDisponibles
    ]);
  }

  public function crear(Request $request)
  {
    $interseccion = Interseccion::with(['bloques.tipo_bloque'])->find($request->id_interseccion);


    return view('dashboard.monitor.simulation', [
      'interseccion' => $interseccion
    ])->with('success', 'Intersección creada correctamente');
  }
}
