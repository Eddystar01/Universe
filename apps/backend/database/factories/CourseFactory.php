<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_id' => Department::factory(),
            'name' => fake()->words(2, true),
            'slug' => fake()->slug(),
            'code' => strtoupper(fake()->bothify('???###')),
            'level' => fake()->randomElement([100, 200, 300, 400, 500]),
            'credit_units' => fake()->numberBetween(1, 6),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
