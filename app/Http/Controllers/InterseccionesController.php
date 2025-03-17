<?php

namespace App\Http\Controllers;

use App\Models\Interseccion;
use Illuminate\Http\Request;

class InterseccionesController extends Controller
{
  public function index()
  {
      $intersecciones = Interseccion::orderBy('id', 'desc')->paginate(10);

      return view('dashboard.admin.intersections.index', ['intersecciones' => $intersecciones]);
  }

  public function detalle($id)
  {
      $interseccion = Interseccion::with(['bloques.tipo_bloque'])->find($id);

      // error_log("log: $interseccion->bloques");
      foreach ($interseccion->bloques as $bloque) {
          error_log($bloque->nombre);
      }
      foreach ($interseccion->bloques as $bloque) {
          error_log($bloque->pivot->tipo_sentido);
      }
      // error_log("log: $interseccion");

      return view('dashboard.admin.intersections.detail', ['interseccion' => $interseccion]);
  }
}
