<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departmentNames = [
            'ADMON Y FINANCIERA',
            'APRENDICES',
            'CES',
            'COMERCIAL',
            'GERENCIA',
            'GESTION HUMANA',
            'MT',
            'PT',
            'PUNTOS DE SERVICIO',
            'SAC',
            'SEGURIDAD',
            'TECNOLOGIA'
        ];
        Department::factory()->count(count($departmentNames))
            ->state(new Sequence(
                fn ($sequence) => ['name' => $departmentNames[$sequence->index]]
            ))
            ->create();
    }
}
