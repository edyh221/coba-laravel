<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function index()
  {
    return \view('user.index', [
      'users' => User::orderBy('created_at', 'DESC')->paginate(10),
      'title' => 'List of Users'
    ]);
  }

  public function update($id, Request $request)
  {
    $user = User::find($id);
    $user->role = $request->role;
    $user->save();
    return \redirect()->back()->with('status', 'Update Role Success');
  }
}
