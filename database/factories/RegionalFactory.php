<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Regional>
 */
class RegionalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
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

        return [
            'name' => $this->faker->randomElement($RegionalNames),
        ];
    }
}
