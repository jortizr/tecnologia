<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
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
        return [
            'name'=> $this->faker->randomElement($departmentNames),
        ];
    }
}
