<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function getUserList () {
    $data = User::orderBy('name', 'asc')->get();
    return response(['data' => $data], 200);
  }
}
