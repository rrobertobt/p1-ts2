<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return redirect()->route('show.login');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::get('/admin/home', function () {
//     return view('admin.home');
// })->name('admin.home')->middleware('auth');

Route::get('/admin/home', function () {
  return view('dashboard.admin.home');
})->name('admin.home');
Route::get('/monitor/home', function () {
  return view('dashboard.monitor.home');
})->name('monitor.home');
Route::get('/supervisor/home', function () {
  return view('dashboard.supervisor.home');
})->name('supervisor.home');
