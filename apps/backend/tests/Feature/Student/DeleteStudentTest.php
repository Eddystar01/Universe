<?php

namespace Tests\Feature\Student;

use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteStudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_delete_student(): void
    {
        $department = Department::factory()->create();

        $student = Student::factory()->create([
            'department_id' => $department->id,
        ]);

        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)
            ->deleteJson("/api/v1/students/{$student->id}");

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Student deleted successfully.',
            ]);

        $this->assertDatabaseMissing('students', [
            'id' => $student->id,
        ]);
    }

    public function test_returns_404_when_student_does_not_exist(): void
    {
        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)
            ->deleteJson('/api/v1/students/00000000-0000-0000-0000-000000000000');

        $response->assertNotFound();
    }
}
