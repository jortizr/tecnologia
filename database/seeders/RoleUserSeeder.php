<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RoleUserSeeder extends Seeder
{
    /**
     * Ejecuta la creacion de los roles en la base de datos
     */
    public function run(): void
    {
        Role::factory()->superadmin()->create();
        Role::factory()->manager()->create();
        Role::factory()->Viewer()->create();


        //obtener todos los roles
        $roles = Role::all();

        //crear los usuarios aleatorios por cada tipo de rol
        $roles->each( function ($role){
            User::factory(2)->create()->each(function ($user) use ($role) {
                $user->roles()->attach($role);
            });
        });
    }

}
