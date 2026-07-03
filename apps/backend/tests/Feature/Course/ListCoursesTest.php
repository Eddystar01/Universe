<?php

namespace Tests\Feature\Course;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListCoursesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_courses(): void
    {
        Course::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/courses');

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonCount(3, 'data');
    }
}
