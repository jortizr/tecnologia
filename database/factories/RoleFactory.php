<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    //proteje el modelo que se va a crear con este factory
    protected $model = \App\Models\Role::class;

    /**
     * se define el estado por defecto del modelo.
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word() . ' Role',
            'description' => $this->faker->sentence(),
        ];
    }
}
