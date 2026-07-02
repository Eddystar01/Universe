<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Concerns\SeedsRoles;

abstract class TestCase extends BaseTestCase
{
    use SeedsRoles;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seedRoles();
    }
}