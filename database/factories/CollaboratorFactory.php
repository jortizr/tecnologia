<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Department;
use App\Models\Occupation;
use App\Models\Regional;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Colaborator>
 */
class CollaboratorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'names' => $this->faker->name,
            'last_name'=> $this->faker->lastName,
            'identification'=> $this->faker->numberBetween(1000000, 9000000),
            'payroll_code'=> $this->faker->bothify('L#####'),
            'department_id'=> Department::factory(),
            'regional_id'=> Regional::factory(),
            'occupation_id'=> Occupation::factory(),
            'is_active'=> true,
        ];
    }
}
