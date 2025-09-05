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

        $this->call([
            RoleSeeder::class,
        ]);

        $user = User::factory()->create([
            'name' => 'Jefferson',
            'email' => 'sisibague@envia.co',
            'password' => bcrypt('apj12345'),
        ]);

        //asignar el rol al usuario creado
        $superadminRole = Role::where('name','Superadmin')->first();
        if ($superadminRole) {
            $user->roles()->attach($superadminRole->id);
        }
    }

}
