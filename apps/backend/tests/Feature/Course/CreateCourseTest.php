<?php

namespace Tests\Feature\Course;

use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_course(): void
    {
        $department = Department::factory()->create();

        $response = $this->postJson('/api/v1/courses', [
            'department_id' => $department->id,
            'name' => 'Introduction to Programming',
            'slug' => 'introduction-to-programming',
            'code' => 'CSC101',
            'level' => 100,
            'credit_units' => 3,
            'description' => 'Basic programming concepts.',
            'is_active' => true,
        ]);

        $response
            ->assertCreated()
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => 'Introduction to Programming',
                    'code' => 'CSC101',
                ],
            ]);

        $this->assertDatabaseHas('courses', [
            'code' => 'CSC101',
        ]);
    }

    public function test_department_id_is_required(): void
    {
        $response = $this->postJson('/api/v1/courses', [
            'name' => 'Introduction to Programming',
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors('department_id');
    }
}
