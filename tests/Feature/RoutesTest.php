<?php
declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    use DatabaseMigrations;

    final public function testHome(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
