<?php
declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class RoutesTest extends TestCase
{
    final public function testHome(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
