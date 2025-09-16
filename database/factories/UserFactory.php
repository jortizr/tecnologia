<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    use HasRoles;
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('apj123456'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(?callable $callback = null): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn (array $attributes, User $user) => [
                    'name' => $user->name.'\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }

    /**
     * Indica que el usuario es un administrador.
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function superadmin()
    {
        return $this->afterCreating(
            function (User $user) {
            $adminRole = Role::where('name','Superadmin')->first();

            if ($adminRole) {
                $user->assignRole($adminRole);
            } else {
                throw new \Exception('Role Superadmin not found. Run RoleSeeder first.');
            }
        });
    }

        /**
     * Indica que el usuario es un usuario moderador, es decir, subadministra con funciones limitadas.
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
   public function manager()
    {
        return $this->afterCreating(function (User $user) {
            // Buscar el rol existente, NO crear uno nuevo
            $managerRole = Role::where('name', 'Manager')->first();

            if ($managerRole) {
                $user->assignRole($managerRole);
            } else {
                throw new \Exception('Role Manager not found. Run RoleSeeder first.');
            }
        });
    }

    /**
     * Indica que el usuario es un usuario visualizador, es decir, solo puede ver contenido.
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function viewer()
    {
        return $this->afterCreating(function (User $user) {
            // Buscar el rol existente, NO crear uno nuevo
            $viewerRole = Role::where('name', 'Viewer')->first();

            if ($viewerRole) {
                $user->assignRole($viewerRole);
            } else {
                throw new \Exception('Role Viewer not found. Run RoleSeeder first.');
            }
        });
    }
}

