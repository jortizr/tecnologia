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
        //creamos los roles basicos
        $this->call([
            RoleSeeder::class,
        ]);

        $user =User::factory()->create([
            'name' => 'Jefferson',
            'email' => 'sisibague@envia.co',
            'password' => bcrypt('apj12345'),
        ]);
        //asignar el rol al usuario creado
        $user->assignRole('Superadmin');

    }

}
