<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Regional;
use Illuminate\Database\Eloquent\Factories\Sequence;

class RegionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $RegionalNames = [
                'Bogota',
                'Cali',
                'Medellin',
                'Barranquilla',
                'Pereira',
                'Bucaramanga',
                'Manizales',
                'Ibague',
                'Pasto',
                'Monteria'];

        Regional::factory()->count(count($RegionalNames))
            ->state(new Sequence(
                fn ($sequence) => ['name' => $RegionalNames[$sequence->index]]
            ))
            ->create();
    }
}
