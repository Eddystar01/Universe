<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Edward Olanrewaju',
            'email' => 'captain@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'student',
        ]);

        $response
            ->assertCreated()
            ->assertJson([
                'success' => true,
                'message' => 'Registration successful.',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'captain@example.com',
        ]);
    }

    public function test_user_cannot_register_with_duplicate_email(): void
    {
        User::factory()->create([
            'email' => 'captain@example.com',
        ]);

        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Edward Olanrewaju',
            'email' => 'captain@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'student',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email',
            ]);
    }

    public function test_password_confirmation_is_required(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Edward Olanrewaju',
            'email' => 'captain@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different-password',
            'role' => 'student',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'password',
            ]);
    }

    public function test_invalid_role_is_rejected(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Edward Olanrewaju',
            'email' => 'captain@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'hacker',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'role',
            ]);
    }

    public function test_name_is_required(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => '',
            'email' => 'captain@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'student',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
            ]);
    }

    public function test_email_is_required(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Edward Olanrewaju',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'student',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email',
            ]);
    }

    public function test_password_must_meet_minimum_length(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Edward Olanrewaju',
            'email' => 'captain@example.com',
            'password' => '123',
            'password_confirmation' => '123',
            'role' => 'student',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'password',
            ]);
    }

    private function validRegistrationData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Edward Olanrewaju',
            'email' => 'captain@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'student',
        ], $overrides);
    }
}
