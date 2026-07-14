<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lecturer>
 */
class LecturerFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_id' => Department::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'staff_id' => strtoupper(fake()->bothify('STF###')),
            'rank' => fake()->randomElement([
                'Graduate Assistant',
                'Assistant Lecturer',
                'Lecturer II',
                'Lecturer I',
                'Senior Lecturer',
                'Associate Professor',
                'Professor',
            ]),
            'bio' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
