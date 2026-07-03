<?php

namespace Tests\Feature\Department;

use App\Models\University;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateDepartmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_department(): void
    {
        $university = University::factory()->create();

        $response = $this->postJson('/api/v1/departments', [
            'university_id' => $university->id,
            'name' => 'Computer Science',
            'slug' => 'computer-science',
            'code' => 'CSC',
            'description' => 'Computer Science Department',
            'is_active' => true,
        ]);

        $response
            ->assertCreated()
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => 'Computer Science',
                    'code' => 'CSC',
                ],
            ]);

        $this->assertDatabaseHas('departments', [
            'name' => 'Computer Science',
        ]);
    }

    public function test_university_id_is_required(): void
    {
        $response = $this->postJson('/api/v1/departments', [
            'name' => 'Computer Science',
            'slug' => 'computer-science',
            'code' => 'CSC',
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors('university_id');
    }
}
