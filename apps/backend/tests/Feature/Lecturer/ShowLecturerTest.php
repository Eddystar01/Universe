<?php

namespace Tests\Feature\Lecturer;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ShowLecturerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_single_lecturer(): void
    {
        $lecturer = Lecturer::factory()->create();

        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)
            ->getJson("/api/v1/lecturers/{$lecturer->id}");

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $lecturer->id,
                ],
            ]);
    }

    public function test_returns_404_when_lecturer_does_not_exist(): void
    {
        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)
            ->getJson('/api/v1/lecturers/'.Str::uuid());

        $response->assertNotFound();
    }
}
