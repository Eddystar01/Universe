<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeTest extends TestCase
{
    use RefreshDatabase;

    private const ME_ENDPOINT = '/api/v1/auth/me';

    public function test_authenticated_user_can_view_profile(): void
    {
        $user = User::factory()->student()->create();

        $token = $user->createToken('test-token')->plainTextToken;

        $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson(self::ME_ENDPOINT)
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Authenticated user retrieved successfully.',
            ]);
    }

    public function test_guest_cannot_view_profile(): void
    {
        $this->getJson(self::ME_ENDPOINT)
            ->assertUnauthorized();
    }

    public function test_profile_contains_expected_fields(): void
    {
        $user = User::factory()->student()->create();

        $token = $user->createToken('test-token')->plainTextToken;

        $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson(self::ME_ENDPOINT)
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'role' => [
                            'name',
                            'slug',
                        ],
                        'email_verified_at',
                        'created_at',
                    ],
                ],
            ]);
    }
}
