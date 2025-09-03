<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    //proteje el modelo que se va a crear con este factory
    protected $model = Role::class;

    /**
     * se define el estado por defecto del modelo.
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique(),
            'description' => $this->faker->sentence(),
        ];
    }

    public function superadmin(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Superadmin',
            'description' => 'Administrator de la plataforma',
        ]);
    }

    public function manager(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Manager',
            'description' => 'Supervisor de la plataforma',
        ]);
    }

    public function Viewer(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Viewer',
            'description' => 'Lector de la plataforma',
        ]);
    }
}
