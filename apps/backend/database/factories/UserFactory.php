<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),

            'role_id' => Role::where('slug', 'student')->value('id'),

            'email' => fake()->unique()->safeEmail(),

            'email_verified_at' => now(),

            'password' => Hash::make('password'),

            'remember_token' => Str::random(10),

            'is_active' => true,

            'last_login_at' => null,
        ];
    }

    public function student(): static
    {
        return $this->state(fn () => [
            'role_id' => Role::where('slug', 'student')->value('id'),
        ]);
    }

    public function lecturer(): static
    {
        return $this->state(fn () => [
            'role_id' => Role::where('slug', 'lecturer')->value('id'),
        ]);
    }

    public function universityAdmin(): static
    {
        return $this->state(fn () => [
            'role_id' => Role::where('slug', 'university_admin')->value('id'),
        ]);
    }

    public function superAdmin(): static
    {
        return $this->state(fn () => [
            'role_id' => Role::where('slug', 'super_admin')->value('id'),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }
}
