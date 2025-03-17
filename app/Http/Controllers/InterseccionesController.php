<?php

namespace App\Http\Controllers;

use App\Models\Bloque;
use App\Models\BloqueInterseccion;
use App\Models\Interseccion;
use App\Models\TipoSentido;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InterseccionesController extends Controller
{
  public function index()
  {
    $intersecciones = Interseccion::orderBy('id', 'desc')->paginate(10);

    return view('dashboard.admin.intersections.index', ['intersecciones' => $intersecciones]);
  }

  public function crear()
  {
    $bloques = Bloque::all();
    $tiposSentido = TipoSentido::all();


    return view('dashboard.admin.intersections.create', [
      'bloques' => $bloques,
      'tiposSentido' => $tiposSentido
    ]);
  }

  public function guardar(Request $request)
  {

    if ($request->vertical_block == $request->horizontal_block) {
      throw ValidationException::withMessages(['error' => 'Los bloques no pueden ser iguales']);
    }

    $verticalBlock = Bloque::find($request->vertical_block);
    $horizontalBlock = Bloque::find($request->horizontal_block);


    if ($verticalBlock->id_tipo == $horizontalBlock->id_tipo) {
      // return redirect()->route('dashboard.admin.intersections.create')->with('error', 'Los bloques no pueden ser del mismo tipo');
      throw ValidationException::withMessages(['error' => 'Los bloques no pueden ser del mismo tipo']);
    }

    $exists = Interseccion::where('id_bloque_vertical', $request->vertical_block)
      ->where('id_bloque_horizontal', $request->horizontal_block)
      ->exists();
      
    if ($exists) {
      throw ValidationException::withMessages(['error' => 'Esta intersección ya existe.']);
    }

    $interseccion = new Interseccion();
    $interseccion->nombre = $request->nombre;
    $interseccion->id_bloque_vertical = $request->vertical_block;
    $interseccion->id_bloque_horizontal = $request->horizontal_block;
    $interseccion->save();


    // create the 4 required associative table records
    $interseccion->bloques()->attach($request->vertical_block, ['id_tipo_sentido' => 1]);
    $interseccion->bloques()->attach($request->vertical_block, ['id_tipo_sentido' => 2]);
    $interseccion->bloques()->attach($request->horizontal_block, ['id_tipo_sentido' => 3]);
    $interseccion->bloques()->attach($request->horizontal_block, ['id_tipo_sentido' => 4]);











    // $data = request()->validate([
    //   'nombre' => 'required',
    //   'bloques' => 'required|array',
    //   'bloques.*' => 'required|exists:bloques,id',
    //   'tipos_sentido' => 'required|array',
    //   'tipos_sentido.*' => 'required|exists:tipo_sentidos,id',
    // ]);

    // $interseccion = new Interseccion();
    // $interseccion->nombre = $data['nombre'];
    // $interseccion->save();

    // $interseccion->bloques()->attach($data['bloques'], ['tipo_sentido' => $data['tipos_sentido']]);

    return redirect()->route('dashboard.admin.intersections.index')->with('message', "Intersección '{$interseccion->nombre}' ha sido creada");
  }

  public function detalle($id)
  {
    $interseccion = Interseccion::with(['bloques.tipo_bloque'])->find($id);


    return view('dashboard.admin.intersections.detail', ['interseccion' => $interseccion]);
  }
}
