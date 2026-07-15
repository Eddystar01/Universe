<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->student(),
            'department_id' => Department::factory(),
            'matric_number' => strtoupper(fake()->bothify('20??/####')),
            'level' => fake()->randomElement([
                '100',
                '200',
                '300',
                '400',
                '500',
            ]),
            'phone' => fake()->phoneNumber(),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }
}
