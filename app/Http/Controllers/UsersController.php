<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
  public function index()
  {
    $users = User::with('role')->orderBy('created_at', 'desc')->paginate(10);

    return view('dashboard.admin.users.index', ['users' => $users]);
  }


  public function create()
  {
    $roles = Role::all();

    return view('dashboard.admin.users.create', ['roles' => $roles]);
  }

  public function store(Request $request)
  {
    error_log("store");
    $request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:8',
      'role_id' => 'required|exists:roles,id',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->role_id = $request->role_id;
    $user->save();

    return redirect()->route('dashboard.admin.users.index')->with('message', 'Usuario ha sido creado');
  }

  public function destroy($id)
  {
    $user = User::findOrFail($id);
    $user->is_active = false;
    $user->save();

    return redirect()->route('dashboard.admin.users.index')->with('message', 'Usuario ha sido desactivado');
  }

  public function restore($id)
  {
    $user = User::findOrFail($id);
    $user->is_active = true;
    $user->save();

    return redirect()->route('dashboard.admin.users.index')->with('message', 'Usuario ha sido activado');
  }
}
