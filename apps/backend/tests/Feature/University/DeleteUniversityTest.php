<?php

namespace Tests\Feature\University;

use App\Models\University;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteUniversityTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_delete_university(): void
    {
        $university = University::factory()->create();

        $this->deleteJson("/api/v1/universities/{$university->id}")
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'University deleted successfully.',
            ]);

        $this->assertDatabaseMissing('universities', [
            'id' => $university->id,
        ]);
    }

    public function test_returns_404_when_deleting_non_existing_university(): void
    {
        $this->deleteJson('/api/v1/universities/00000000-0000-0000-0000-000000000000')
            ->assertNotFound();
    }
}
