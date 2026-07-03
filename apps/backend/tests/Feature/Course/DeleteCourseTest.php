<?php

namespace Tests\Feature\Course;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_delete_course(): void
    {
        $course = Course::factory()->create();

        $response = $this->deleteJson('/api/v1/courses/'.$course->id);

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Course deleted successfully.',
            ]);

        $this->assertDatabaseMissing('courses', [
            'id' => $course->id,
        ]);
    }

    public function test_returns_404_when_deleting_non_existing_course(): void
    {
        $response = $this->deleteJson('/api/v1/courses/non-existing-id');

        $response->assertNotFound();
    }
}
