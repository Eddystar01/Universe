<?php

namespace Tests\Feature\University;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUniversityTest extends TestCase
{
    use RefreshDatabase;

    private const ENDPOINT = '/api/v1/universities';

    public function test_can_create_university(): void
    {
        $payload = [
            'name' => 'University of Ibadan',
            'email' => 'info@ui.edu.ng',
            'phone' => '08012345678',
            'website' => 'https://ui.edu.ng',
            'address' => 'Ibadan',
            'city' => 'Ibadan',
            'state' => 'Oyo',
            'country' => 'Nigeria',
        ];

        $this->postJson(self::ENDPOINT, $payload)
            ->assertCreated()
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('universities', [
            'name' => 'University of Ibadan',
        ]);
    }

    public function test_name_is_required(): void
    {
        $this->postJson(self::ENDPOINT, [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }
}
