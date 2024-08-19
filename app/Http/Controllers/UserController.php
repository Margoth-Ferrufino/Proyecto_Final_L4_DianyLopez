<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index',$usuarios);
    }

    public function show($id)
    {
        $usuario = User::findOrFail($id);
        return view('usuarios.show',$usuario);
    }
}
