<?php

namespace App\Http\Controllers;

use App\Models\Simulacion;
use App\Models\User;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class ReportesController extends Controller
{
  public function userReports(Request $request)
  {
    $id = $request->get('usuario');
    return redirect()->route('dashboard.supervisor.reports', ['usuario' => $id]);
  }

  public function index()
  {
    //only users with role_id =1 and is_active = true
    $usuarios = 
      User::where('role_id', 1)
      ->where('is_active', true)
      ->get();



    $simulacionesCount = Simulacion::count();

    $simulacionesArchivo = Simulacion::where('modalidad', 'archivo')->count();
    $simulacionesAleatorio = Simulacion::where('modalidad', 'random')->count();

    // $usuarioMasSimulaciones = Simulacion::select('id_usuario')
    //   ->selectRaw('count(id_usuario) as total')
    //   ->groupBy('id_usuario')
    //   ->orderBy('total', 'desc')
    //   ->first();
    $usuarioMasSimulaciones = Simulacion::with('usuario')
      ->select('id_usuario')
      ->selectRaw('count(id_usuario) as total')
      ->groupBy('id_usuario')
      ->orderBy('total', 'desc')
      ->first();

    $totalVehiculos = Vehiculo::count();

    //check if there is user_id query parameter and get the user simulations
    $userIndividualData = null;
    if (request()->has('usuario')) {
      $user_id = request()->get('usuario');
      $simulaciones = Simulacion::where('id_usuario', $user_id)->get();
      $userIndividualData = [
        'simulaciones' => $simulaciones,
        'usuario' => User::find($user_id)
      ];
    }
    error_log(json_encode($userIndividualData));


    return view('dashboard.supervisor.reports',[
      'simulacionesCount' => $simulacionesCount,
      'simulacionesArchivo' => $simulacionesArchivo,
      'simulacionesAleatorio' => $simulacionesAleatorio,
      'usuarioMasSimulaciones' => $usuarioMasSimulaciones,
      'totalVehiculos' => $totalVehiculos,
      'usuarios' => $usuarios,
      'userIndividualData' => $userIndividualData
    ]);
  }
}
