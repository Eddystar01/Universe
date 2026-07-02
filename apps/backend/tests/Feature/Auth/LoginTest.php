<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private const LOGIN_ENDPOINT = '/api/v1/auth/login';

    public function test_user_can_login(): void
    {
        $user = User::factory()->student()->create([
            'email' => 'captain@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson(
            self::LOGIN_ENDPOINT,
            [
                'email' => 'captain@example.com',
                'password' => 'password123',
            ]
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Login successful.',
            ]);

        $this->assertNotEmpty(
            $response->json('data.authorization.token')
        );
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        User::factory()->student()->create([
            'email' => 'captain@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson(
            self::LOGIN_ENDPOINT,
            [
                'email' => 'captain@example.com',
                'password' => 'wrong-password',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email',
            ]);
    }

    public function test_user_cannot_login_with_unknown_email(): void
    {
        $response = $this->postJson(
            self::LOGIN_ENDPOINT,
            [
                'email' => 'unknown@example.com',
                'password' => 'password123',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email',
            ]);
    }

    public function test_inactive_user_cannot_login(): void
    {
        User::factory()
            ->student()
            ->inactive()
            ->create([
                'email' => 'captain@example.com',
                'password' => bcrypt('password123'),
            ]);

        $response = $this->postJson(
            self::LOGIN_ENDPOINT,
            [
                'email' => 'captain@example.com',
                'password' => 'password123',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email',
            ]);
    }

    public function test_login_updates_last_login_at(): void
    {
        $user = User::factory()
            ->student()
            ->create([
                'email' => 'captain@example.com',
                'password' => bcrypt('password123'),
                'last_login_at' => null,
            ]);

        $this->postJson(
            self::LOGIN_ENDPOINT,
            [
                'email' => 'captain@example.com',
                'password' => 'password123',
            ]
        )->assertOk();

        $this->assertNotNull(
            $user->fresh()->last_login_at
        );
    }

    public function test_login_creates_sanctum_token(): void
    {
        $user = User::factory()
            ->student()
            ->create([
                'email' => 'captain@example.com',
                'password' => bcrypt('password123'),
            ]);

        $this->postJson(
            self::LOGIN_ENDPOINT,
            [
                'email' => 'captain@example.com',
                'password' => 'password123',
            ]
        )->assertOk();

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);
    }

    private function createUser(array $overrides = []): User
    {
        return User::factory()
            ->student()
            ->create(array_merge([
                'password' => bcrypt('password123'),
            ], $overrides));
    }
}
