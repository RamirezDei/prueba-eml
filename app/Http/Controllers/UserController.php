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

    public function store(Request $request)
    {
        $messages = [
            'nombres.required' => 'El campo nombres es requerido.',
            'apellidos.required' => 'El campo apellidos es requerido.',
            'correo.required' => 'El campo correo es requerido.',
            'correo.email' => 'El campo correo debe ser un correo válido.',
            'correo.unique' => 'El correo ya está en uso.',
            'telefono.numeric' => 'El campo teléfono debe ser un número.'
        ];
        
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'correo' => 'required|email|unique:users',
            'telefono' => 'nullable|numeric'
        ], $messages);

        $user = new User();
        $user->nombres = $request->nombres;
        $user->apellidos = $request->apellidos;
        $user->correo = $request->correo;
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
        $messages = [
            'nombres.required' => 'El campo nombres es requerido.',
            'apellidos.required' => 'El campo apellidos es requerido.',
            'correo.required' => 'El campo correo es requerido.',
            'correo.email' => 'El campo correo debe ser un correo válido.',
            'correo.unique' => 'El correo ya está en uso.',
            'telefono.numeric' => 'El campo teléfono debe ser un número.'
        ];
        
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'correo' => 'required|email|unique:users,correo,'.$id,
            'telefono' => 'nullable|numeric'
        ], $messages);

        $user = User::findOrFail($id);
        $user->nombres = $request->nombres;
        $user->apellidos = $request->apellidos;
        $user->correo = $request->correo;
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