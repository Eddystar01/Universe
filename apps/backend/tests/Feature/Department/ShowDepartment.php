<?php

namespace Tests\Feature\Department;

use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowDepartmentTest extends TestCase
{
    use RefreshDatabase;

    private const ENDPOINT = '/api/v1/departments';

    public function test_can_view_single_department(): void
    {
        $department = Department::factory()->create();

        $this->getJson(self::ENDPOINT.'/'.$department->id)
            ->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $department->id,
                    'name' => $department->name,
                ],
            ]);
    }

    public function test_returns_404_when_department_does_not_exist(): void
    {
        $this->getJson(self::ENDPOINT.'/invalid-id')
            ->assertNotFound();
    }
}
