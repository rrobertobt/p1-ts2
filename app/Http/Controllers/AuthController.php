<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function showLogin()
  {
    return view('auth.login');
  }

  public function login(Request $request)
  {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();

      
      // get the role from the role_id from the user
      $roleId = $request->user()->role_id;
      $role = Role::find($roleId);
      $roleSlug = $role->slug;

      switch ($roleSlug) {
        case 'admin':
          return redirect()->route('admin.home');
          break;
        case 'monitor':
          return redirect()->route('monitor.home');
          break;
        case 'supervisor':
          return redirect()->route('supervisor.home');
          break;
        default:
          return redirect()->route('login');
          break;
      }

      return redirect()->route('login');
    }
    return redirect('login')->with('error', 'Parece que las credenciales no son correctas, por favor intenta de nuevo.');
  }

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();

    return redirect()->route('show.login');
  }
}
