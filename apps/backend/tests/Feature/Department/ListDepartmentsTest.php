<?php

namespace Tests\Feature\Department;

use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListDepartmentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_departments(): void
    {
        Department::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/departments');

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonCount(3, 'data');
    }
}
