<?php

namespace Tests\Feature\University;

use App\Models\University;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListUniversitiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_universities(): void
    {
        University::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/universities');

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonCount(3, 'data');
    }
}
