<?php

namespace Tests\Feature\Lecturer;

use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateLecturerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_lecturer(): void
    {
        $department = Department::factory()->create();

        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)->postJson(
            '/api/v1/lecturers',
            [
                'department_id' => $department->id,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'phone' => '08012345678',
                'staff_id' => 'STF001',
                'rank' => 'Senior Lecturer',
                'bio' => 'Cybersecurity Lecturer',
                'is_active' => true,
            ]
        );

        $response
            ->assertCreated()
            ->assertJson([
                'success' => true,
                'data' => [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'staff_id' => 'STF001',
                ],
            ]);

        $this->assertDatabaseHas('lecturers', [
            'email' => 'john@example.com',
            'staff_id' => 'STF001',
        ]);
    }

    public function test_department_id_is_required(): void
    {
        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)->postJson(
            '/api/v1/lecturers',
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'staff_id' => 'STF001',
                'rank' => 'Senior Lecturer',
                'is_active' => true,
            ]
        );

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors('department_id');
    }
}
