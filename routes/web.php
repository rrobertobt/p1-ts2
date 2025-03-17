<?php

use App\Http\Controllers\AuthController;
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
  Route::get('/admin/home', function () {
    return view('dashboard.admin.home');
  })->name('admin.home');
  Route::get('/admin/users', [UsersController::class, 'index'])->name('dashboard.admin.users.index');
  Route::get('/admin/users/create', [UsersController::class, 'create'])->name('dashboard.admin.users.create');
  Route::post('/admin/users', [UsersController::class, 'store'])->name('admin.users.store');
  Route::delete('/admin/users/{id}', [UsersController::class, 'destroy'])->name('admin.users.destroy');
  Route::post('/admin/users/{id}/restore', [UsersController::class, 'restore'])->name('admin.users.restore');


  //Monitor routes
  Route::get('/monitor/home', function () {
    return view('dashboard.monitor.home');
  })->name('monitor.home');



  //Supervisor routes
  Route::get('/supervisor/home', function () {
    return view('dashboard.supervisor.home');
  })->name('supervisor.home');
  
});
