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
            'APRENDIZ SENA',
            'ASESOR DE SERVICIO AL CLIENTE',
            'ASESOR DE SERVICIO AL CLIENTE DEDICADO',
            'AUXILIAR ADMINISTRATIVO (A)',
            'AUXILIAR ADMINISTRATIVO II control recaudos',
            'AUXILIAR CARGUE Y DESCARGUE',
            'AUXILIAR DE CUMPLIDOS',
            'AUXILIAR DE MALLA',
            'AUXILIAR OPERATIVO',
            'AUXILIAR PUNTOS DE SERVICIO',
            'CONDUCTOR',
            'COORDINADOR (A) OPERATIVO (A)',
            'COORDINADOR (A) ZONAL DE PUNTO DE SERVICIO',
            'COORDINADOR DE GESTION HUMANA',
            'COORDINADOR DE TECNOLOGIA',
            'COORDINADOR(A) ADMINISTRATIVO(A)',
            'EJECUTIVO(A) JUNIOR ASESOR(A) CIAL',
            'EJECUTIVO(A) SENIOR EJECUTIVO (A) CIAL',
            'ESTUDIANTE EN PRACTICA',
            'GERENTE REGIONAL',
            'LIDER REGIONAL GESTION HUMANA I',
            'MENSAJERO MOTO',
            'MENSAJERO MOTO PPP',
            'OPERADOR DE CARGUE Y DESCARGUE',
            'OPERADOR DE SERVICIO',
            'PROMOTOR (A) COMERCIAL DE PUNTO DE SERVICIO',
            'SUPERVISOR (A) OPERATIVO',
            'VIGILANTE'
];
        return [
            'name' => $this->faker->randomElement($occupationNames),
        ];
    }
}
