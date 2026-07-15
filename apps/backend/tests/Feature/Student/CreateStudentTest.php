<?php

namespace Tests\Feature\Student;

use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateStudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_student(): void
    {
        $department = Department::factory()->create();
        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)->postJson(
            '/api/v1/students',
            [
                'user_id' => $user->id,
                'department_id' => $department->id,
                'matric_number' => 'CSC/2024/001',
                'level' => '300',
                'phone' => '08012345678',
                'is_active' => true,
            ]
        );

        $response
            ->assertCreated()
            ->assertJson([
                'success' => true,
                'data' => [
                    'user_id' => $user->id,
                    'department_id' => $department->id,
                    'matric_number' => 'CSC/2024/001',
                    'level' => '300',
                ],
            ]);

        $this->assertDatabaseHas('students', [
            'matric_number' => 'CSC/2024/001',
        ]);
    }

    public function test_user_id_is_required(): void
    {
        $department = Department::factory()->create();
        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)->postJson(
            '/api/v1/students',
            [
                'department_id' => $department->id,
                'matric_number' => 'CSC/2024/001',
                'level' => '300',
                'is_active' => true,
            ]
        );

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors('user_id');
    }
}
