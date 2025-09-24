<?php

namespace Database\Seeders;

use App\Models\Occupation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Occupation::firstOrCreate([
            "name"=> "Mensajero",
        ]);
        Occupation::firstOrCreate([
            "name"=> "Operador de servicio",
        ]);
        Occupation::firstOrCreate([
            "name"=> "Conductor",
        ]);
    }
}
