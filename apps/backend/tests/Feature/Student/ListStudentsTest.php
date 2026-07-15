<?php

namespace Tests\Feature\Student;

use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListStudentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_students(): void
    {
        $department = Department::factory()->create();

        Student::factory()->count(3)->create([
            'department_id' => $department->id,
        ]);

        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)
            ->getJson('/api/v1/students');

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonCount(3, 'data');
    }
}
