<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function getUsers()
    {
        $users = User::all();
        return Datatables::of($users)->toJson();
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->nombres = $request->nombres;
        $user->apellidos = $request->apellidos;
        $user->telefono = $request->telefono;
        $user->fecha_registro = now();
        $user->fecha_modificacion = now();
        $user->save();

        return response()->json(['success' => 'Usuario creado exitosamente.']);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->nombres = $request->nombres;
        $user->apellidos = $request->apellidos;
        $user->telefono = $request->telefono;
        $user->fecha_modificacion = now();
        $user->save();

        return response()->json(['success' => 'Usuario actualizado exitosamente.']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => 'Usuario eliminado exitosamente.']);
    }
}
