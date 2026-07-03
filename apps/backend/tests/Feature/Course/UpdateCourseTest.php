<?php

namespace Tests\Feature\Course;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateCourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_course(): void
    {
        $course = Course::factory()->create();

        $response = $this->putJson(
            '/api/v1/courses/'.$course->id,
            [
                'department_id' => $course->department_id,
                'name' => 'Advanced Programming',
                'slug' => 'advanced-programming',
                'code' => 'CSC401',
                'level' => 400,
                'credit_units' => 4,
                'description' => 'Advanced programming concepts.',
                'is_active' => true,
            ]
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => 'Advanced Programming',
                    'code' => 'CSC401',
                ],
            ]);
    }

    public function test_name_is_required_when_updating(): void
    {
        $course = Course::factory()->create();

        $response = $this->putJson(
            '/api/v1/courses/'.$course->id,
            [
                'department_id' => $course->department_id,
                'name' => '',
                'slug' => 'advanced-programming',
                'code' => 'CSC401',
                'level' => 400,
                'credit_units' => 4,
            ]
        );

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }
}
