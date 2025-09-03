<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Carbon\Factory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->createRoles();
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Jefferson',
            'email' => 'sisibague@envia.co',
            'password' => bcrypt('apj12345'),
        ]);

        //asignar el rol al usuario creado
        $superadminRole = Role::where('name','Superadmin')->first();
        if ($superadminRole) {
            $user->roles()->attach($superadminRole->id)->timestamps();
        }
    }

    /**
     * funcion que crea los roles basicos en la BD atraves del factory RoleFactory que se creo en el archivo RoleFactory.php
     * @return void
     */
    protected function createRoles()
    {
        Role::factory()->superadmin()->create();
        Role::factory()->manager()->create();
        Role::factory()->Viewer()->create();
    }


}
