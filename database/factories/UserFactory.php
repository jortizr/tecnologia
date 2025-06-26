<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use App\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
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
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
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
    public function administrator()
    {
        return $this->afterCreating(
            function (User $user) {
            $adminRole = Role::firstOrCreate(['name' => 'Administrator']);
            $adminRole->description = 'Administrator User';
            $adminRole->save();
            // Asigna el rol de administrador al usuario
            $user->roles()->attach($adminRole);
        });
    }

        /**
     * Indica que el usuario es un usuario moderador, es decir, subadministra con funciones limitadas.
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function moderator()
    {
        return $this->afterCreating(
            function (User $user) {
            $moderatorRole = Role::firstOrCreate(['name' => 'Moderator']);
            $moderatorRole->description = 'Moderator User';
            $moderatorRole->save();
            // Asigna el rol de moderador al usuario
            $user->roles()->attach($moderatorRole);
        });
    }
}
