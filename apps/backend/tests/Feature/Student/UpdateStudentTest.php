<?php

namespace Tests\Feature\Student;

use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateStudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_student(): void
    {
        $department = Department::factory()->create();

        $student = Student::factory()->create([
            'department_id' => $department->id,
        ]);

        $newDepartment = Department::factory()->create();

        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)->putJson(
            "/api/v1/students/{$student->id}",
            [
                'department_id' => $newDepartment->id,
                'matric_number' => 'CSC/2025/001',
                'level' => '300',
                'phone' => '08012345678',
                'is_active' => true,
            ]
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'department_id' => $newDepartment->id,
                    'matric_number' => 'CSC/2025/001',
                    'level' => '300',
                ],
            ]);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'department_id' => $newDepartment->id,
            'matric_number' => 'CSC/2025/001',
            'level' => '300',
            'phone' => '08012345678',
            'is_active' => true,
        ]);
    }

    public function test_matric_number_is_required_when_updating(): void
    {
        $department = Department::factory()->create();

        $student = Student::factory()->create([
            'department_id' => $department->id,
        ]);

        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)->putJson(
            "/api/v1/students/{$student->id}",
            [
                'matric_number' => '',
            ]
        );

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors('matric_number');
    }
}
