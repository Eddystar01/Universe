<?php

namespace Tests\Feature\University;

use App\Models\University;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowUniversityTest extends TestCase
{
    use RefreshDatabase;

    private const ENDPOINT = '/api/v1/universities';

    public function test_can_view_single_university(): void
    {
        $university = University::factory()->create();

        $this->getJson(self::ENDPOINT.'/'.$university->id)
            ->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $university->id,
                    'name' => $university->name,
                    'slug' => $university->slug,
                ],
            ]);
    }

    public function test_returns_404_when_university_does_not_exist(): void
    {
        $this->getJson(self::ENDPOINT.'/00000000-0000-0000-0000-000000000000')
            ->assertNotFound();
    }
}
