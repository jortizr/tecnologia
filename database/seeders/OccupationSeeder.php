<?php

namespace Database\Seeders;

use App\Models\Occupation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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
        Occupation::factory()->count(count($occupationNames))
            ->state(new Sequence(
                fn ($sequence) => ['name' => $occupationNames[$sequence->index]]
            ))
            ->create();
    }
}
