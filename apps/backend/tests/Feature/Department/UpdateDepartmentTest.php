<?php

namespace Tests\Feature\Department;

use App\Models\Department;
use App\Models\University;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateDepartmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_department(): void
    {
        $department = Department::factory()->create();

        $newUniversity = University::factory()->create();

        $response = $this->putJson(
            '/api/v1/departments/'.$department->id,
            [
                'university_id' => $newUniversity->id,
                'name' => 'Software Engineering',
                'slug' => 'software-engineering',
                'code' => 'SWE',
                'description' => 'Updated department',
                'is_active' => false,
            ]
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => 'Software Engineering',
                    'code' => 'SWE',
                ],
            ]);

        $this->assertDatabaseHas('departments', [
            'id' => $department->id,
            'name' => 'Software Engineering',
            'code' => 'SWE',
        ]);
    }

    public function test_name_is_required_when_updating(): void
    {
        $department = Department::factory()->create();

        $response = $this->putJson(
            '/api/v1/departments/'.$department->id,
            [
                'name' => '',
            ]
        );

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }
}
