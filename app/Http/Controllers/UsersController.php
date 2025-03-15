<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
  public function index()
  {
    // route --> /ninjas
    $users = User::with('role')->orderBy('created_at', 'desc')->paginate(10);

    return view('dashboard.admin.users.index', ['users' => $users]);
  }


  public function create()
  {
    // route --> /ninjas/create
    $roles = Role::all();

    return view('admin.users.create', ['roles' => $roles]);
  }
}
