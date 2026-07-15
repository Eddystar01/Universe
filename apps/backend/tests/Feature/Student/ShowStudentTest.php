<?php

namespace Tests\Feature\Student;

use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowStudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_single_student(): void
    {
        $department = Department::factory()->create();

        $student = Student::factory()->create([
            'department_id' => $department->id,
        ]);

        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)
            ->getJson("/api/v1/students/{$student->id}");

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $student->id,
                    'matric_number' => $student->matric_number,
                    'department_id' => $department->id,
                ],
            ]);
    }

    public function test_returns_404_when_student_does_not_exist(): void
    {
        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)
            ->getJson('/api/v1/students/non-existing-id');

        $response->assertNotFound();
    }
}
