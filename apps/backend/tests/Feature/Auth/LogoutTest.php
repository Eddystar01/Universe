<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\SeedsRoles;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    use SeedsRoles;

    private const LOGOUT_ENDPOINT = '/api/v1/auth/logout';

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->student()->create();

        $token = $user->createToken('test-token')->plainTextToken;

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson(self::LOGOUT_ENDPOINT)
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Logout successful.',
            ]);
    }

    public function test_logout_deletes_current_token(): void
    {
        $user = User::factory()->student()->create();

        $token = $user->createToken('test-token')->plainTextToken;

        $this->assertDatabaseCount('personal_access_tokens', 1);

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson(self::LOGOUT_ENDPOINT)
            ->assertOk();

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_guest_cannot_logout(): void
    {
        $this->postJson(self::LOGOUT_ENDPOINT)
            ->assertUnauthorized();
    }
}
