<?php

namespace Tests\Feature\University;

use App\Models\University;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateUniversityTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_university(): void
    {
        $university = University::factory()->create();

        $payload = [
            'name' => 'Updated University',
            'email' => 'updated@example.com',
            'city' => 'Lagos',
        ];

        $this->putJson("/api/v1/universities/{$university->id}", $payload)
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('universities', [
            'id' => $university->id,
            'name' => 'Updated University',
            'email' => 'updated@example.com',
            'city' => 'Lagos',
        ]);
    }

    public function test_name_is_required_when_updating(): void
    {
        $university = University::factory()->create();

        $this->putJson("/api/v1/universities/{$university->id}", [
            'name' => '',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }
}
