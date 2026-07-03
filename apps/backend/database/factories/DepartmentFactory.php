<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\University;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'university_id' => University::factory(),
            'name' => fake()->company().' Department',
            'slug' => fake()->slug(),
            'code' => strtoupper(fake()->bothify('???###')),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
