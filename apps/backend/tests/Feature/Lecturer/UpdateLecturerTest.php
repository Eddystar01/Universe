<?php

namespace Tests\Feature\Lecturer;

use App\Models\Department;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateLecturerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_lecturer(): void
    {
        $department = Department::factory()->create();

        $lecturer = Lecturer::factory()->create([
            'department_id' => $department->id,
        ]);

        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)->putJson(
            "/api/v1/lecturers/{$lecturer->id}",
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'phone' => '08012345678',
                'staff_id' => 'STF001',
                'rank' => 'Senior Lecturer',
                'bio' => 'Updated bio',
                'is_active' => true,
            ]
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'staff_id' => 'STF001',
                ],
            ]);

        $this->assertDatabaseHas('lecturers', [
            'id' => $lecturer->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'staff_id' => 'STF001',
        ]);
    }

    public function test_first_name_is_required_when_updating(): void
    {
        $department = Department::factory()->create();

        $lecturer = Lecturer::factory()->create([
            'department_id' => $department->id,
        ]);

        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)->putJson(
            "/api/v1/lecturers/{$lecturer->id}",
            [
                'first_name' => '',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'staff_id' => 'STF001',
                'rank' => 'Senior Lecturer',
                'is_active' => true,
            ]
        );

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors('first_name');
    }
}