<?php

namespace Tests\Feature\Lecturer;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListLecturersTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_lecturers(): void
    {
        Lecturer::factory()->count(3)->create();

        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)
            ->getJson('/api/v1/lecturers');

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonCount(3, 'data');
    }
}
