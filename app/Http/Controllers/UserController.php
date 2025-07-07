<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class UserController extends Controller
{

    public function index(){
        //obtener todos los usuarios
        $users = User::with('roles')->get();

        //retornar la vista con los usuarios
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function create(){
        //obtener todos los roles
        $roles = Role::all();

        //retornar la vista de creación de usuario con los roles
        return view('users.create', compact('roles'));
    }

    public function store(Request $request){
        //validar los datos del frontend
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,id',
        ]);

        //crear el nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),//se hasshea el pass
        ]);

        //asignar el rol al usuario
        $role = Role::find($request->role);
        if($role){
            $user->roles()->attach($role->id);
        } else {
            return redirect()->back()->withErrors(['role' => 'El rol seleccionado no es válido.']);
        }

        //redireccionar a la lista de usuarios
        return redirect()->route('users.index')->with('success', 'Usuario creado existosamente');

    }
}
