<?php

namespace Database\Seeders;

use App\Models\User;
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
        //creamos los roles basicos
        $this->call([
            RoleSeeder::class,
            RegionalSeeder::class,
            DepartmentSeeder::class,
            OccupationSeeder::class,
            CollaboratorSeeder::class,
        ]);

        $user =User::factory()->create([
            'name' => 'Jefferson',
            'last_name'=> 'Ortiz',
            'email' => 'sisibague@envia.co',
            'password' => bcrypt('apj12345'),
        ]);
        //asignar el rol al usuario creado
        $user->assignRole('Superadmin');

        $user2 =User::factory()->create([
            'name' => 'Juan',
            'last_name'=> 'Ortiz',
            'email' => 'test2@envia.co',
            'password' => bcrypt('apj12345'),
        ]);
        //asignar el rol al usuario creado
        $user2->assignRole('Superadmin');

    }

}
