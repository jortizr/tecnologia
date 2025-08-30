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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Jefferson',
            'email' => 'sisibague@envia.co',
            'password' => bcrypt('apj12345'),
        ]);

        $this->createRoles();
    }

    /**
     * funcion que crea los roles basicos en la BD atraves del factory RoleFactory que se creo en el archivo RoleFactory.php
     * @return void
     */
    protected function createRoles()
    {
        Role::factory()->administrator()->create();
        Role::factory()->manager()->create();
        Role::factory()->Viewer()->create();
    }


}
