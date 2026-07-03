<?php

namespace Tests\Feature\Department;

use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteDepartmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_delete_department(): void
    {
        $department = Department::factory()->create();

        $this->deleteJson('/api/v1/departments/'.$department->id)
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseMissing('departments', [
            'id' => $department->id,
        ]);
    }

    public function test_returns_404_when_deleting_non_existing_department(): void
    {
        $this->deleteJson('/api/v1/departments/invalid-id')
            ->assertNotFound();
    }
}
