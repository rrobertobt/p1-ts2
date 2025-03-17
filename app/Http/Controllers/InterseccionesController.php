<?php

namespace App\Http\Controllers;

use App\Models\Interseccion;
use Illuminate\Http\Request;

class InterseccionesController extends Controller
{
  public function index()
  {
      $intersecciones = Interseccion::all();
      error_log(json_encode($intersecciones));

      return view('dashboard.admin.intersections.index', ['intersecciones' => $intersecciones]);
  }
}
