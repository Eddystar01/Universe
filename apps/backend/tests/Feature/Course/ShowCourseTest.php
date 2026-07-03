<?php

namespace Tests\Feature\Course;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowCourseTest extends TestCase
{
    use RefreshDatabase;

    private const ENDPOINT = '/api/v1/courses';

    public function test_can_view_single_course(): void
    {
        $course = Course::factory()->create();

        $this->getJson(self::ENDPOINT.'/'.$course->id)
            ->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $course->id,
                ],
            ]);
    }

    public function test_returns_404_when_course_does_not_exist(): void
    {
        $this->getJson(self::ENDPOINT.'/invalid-id')
            ->assertNotFound();
    }
}
