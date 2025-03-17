<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BloquesController;
use App\Http\Controllers\InterseccionesController;
use App\Http\Controllers\SimulacionesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return redirect()->route('show.login');
})->name('home');


Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
  //Admin routes
  Route::get('/admin/inicio', function () {
    return view('dashboard.admin.home');
  })->name('dashboard.admin.home');
  Route::get('/admin/usuarios', [UsersController::class, 'index'])->name('dashboard.admin.users.index');
  Route::get('/admin/usuarios/create', [UsersController::class, 'create'])->name('dashboard.admin.users.create');
  Route::post('/admin/usuarios', [UsersController::class, 'store'])->name('admin.users.store');
  Route::delete('/admin/usuarios/{id}', [UsersController::class, 'destroy'])->name('admin.users.destroy');
  Route::post('/admin/usuarios/{id}/restaurar', [UsersController::class, 'restore'])->name('admin.users.restore');

  Route::get('/admin/bloques', [BloquesController::class, 'index'])->name('dashboard.admin.blocks.index');
  Route::post('/admin/bloques', [BloquesController::class, 'guardar'])->name('dashboard.admin.blocks.store');
  Route::get('/admin/bloques/crear', [BloquesController::class, 'crear'])->name('dashboard.admin.blocks.create');
  Route::get('/admin/intersecciones', [InterseccionesController::class, 'index'])->name('dashboard.admin.intersections.index');
  Route::post('/admin/intersecciones', [InterseccionesController::class, 'guardar'])->name('dashboard.admin.intersections.store');
  Route::get('/admin/intersecciones/crear', [InterseccionesController::class, 'crear'])->name('dashboard.admin.intersections.create');
  Route::get('/admin/intersecciones/{id}', [InterseccionesController::class, 'detalle'])->name('dashboard.admin.intersections.detail');


  //Monitor routes
  Route::get('/monitor/home', function () {
    return view('dashboard.monitor.home');
  })->name('monitor.home');
  Route::get('/monitor/simulacion', [
    SimulacionesController::class, 'simulacion'
  ])->name('monitor.simulacion');



  //Supervisor routes
  Route::get('/supervisor/home', function () {
    return view('dashboard.supervisor.home');
  })->name('supervisor.home');
  
});
