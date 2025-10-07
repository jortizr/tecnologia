<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Occupation>
 */
class OccupationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $occupationNames = [
                'MENSAJERO MOTO', 'CONDUCTOR', 'AUXILIAR OPERATIVO', 'OPERADOR DE SERVICIO', 'ASESOR DE SERVICIO AL CLIENTE', 'AUXILIAR DE MALLA', 'AUXILIAR CARGUE Y DESCARGUE', 'SUPERVISOR (A) OPERATIVO', 'AUXILIAR ADMINISTRATIVO (A)', 'COORDINADOR (A) OPERATIVO (A)', 'PROMOTOR (A) COMERCIAL DE PUNTO DE SERVICIO', 'COORDINADOR DE TECNOLOGIA'. 'EJECUTIVO(A) JUNIOR ASESOR(A) CIAL', 'AUXILIAR ADMINISTRATIVO (A)', 'COORDINADOR (A) ZONAL DE PUNTO DE SERVICIO', 'GERENTE REGIONAL'];
        return [
            'name' => $this->faker->randomElement($occupationNames),
        ];
    }
}
