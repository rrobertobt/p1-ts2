<?php

namespace App\Http\Controllers;

use App\Models\Bloque;
use App\Models\Interseccion;
use App\Models\TipoBloque;
use Illuminate\Http\Request;

class BloquesController extends Controller
{
    public function index()
    {
        $bloques = Bloque::with('tipo_bloque')->orderBy('id', 'desc')->paginate(10);

        return view('dashboard.admin.blocks.index', ['bloques' => $bloques]);
    }

    public function crear()
    {
        $tiposBloque = TipoBloque::all();

        return view('dashboard.admin.blocks.create', ['tiposBloque' => $tiposBloque]);
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:bloque,nombre',
            'numero' => 'nullable',
            'id_tipo' => 'required|exists:tipo_bloque,id',
        ]);

        $bloque = new Bloque();
        $bloque->nombre = $request->nombre;
        $bloque->numero = $request->numero;
        $bloque->id_tipo = $request->id_tipo;
        $bloque->save();

        return redirect()->route('dashboard.admin.blocks.index')->with('message', 'Bloque ha sido creado');
    }

}
