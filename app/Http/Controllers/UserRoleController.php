<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserRoleController extends Controller
{
    //
    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);


        $role = Role::findOrFail($request->role_id);
        //asignar un rol a un usuario
        $user->roles()->attach($role);

        return redirect()->route('users.show', $user)
            ->with('success', 'rol asignado correctamente');
    }
}
