<?php

namespace Tests\Feature\Lecturer;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class DeleteLecturerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_delete_lecturer(): void
    {
        $lecturer = Lecturer::factory()->create();

        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)
            ->deleteJson("/api/v1/lecturers/{$lecturer->id}");

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseMissing('lecturers', [
            'id' => $lecturer->id,
        ]);
    }

    public function test_returns_404_when_deleting_non_existing_lecturer(): void
    {
        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)
            ->deleteJson('/api/v1/lecturers/'.Str::uuid());

        $response->assertNotFound();
    }
}