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
  Route::get('/admin/users', [UsersController::class, 'index'])->name('admin.users.index');
  Route::get('/admin/users/create', [UsersController::class, 'create'])->name('admin.users.create');


  //Monitor routes
  Route::get('/monitor/home', function () {
    return view('dashboard.monitor.home');
  })->name('monitor.home');



  //Supervisor routes
  Route::get('/supervisor/home', function () {
    return view('dashboard.supervisor.home');
  })->name('supervisor.home');
  
});
