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

    final public function testContactmomentenImporteer(): void
    {
        $response = $this->get('/contactmomenten/importeer');
        $response->assertStatus(200);
    }
}
