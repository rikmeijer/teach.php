<?php declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ContactmomentenImporterenTest extends TestCase
{
    use DatabaseMigrations;

    final public function testContactmomentenImporteer(): void
    {
        $response = $this->get('/contactmomenten/importeer');
        $response->assertStatus(200);
    }


    final public function testContactmomentenGeimporteerd(): void
    {
        $response = $this->get('/contactmomenten/geimporteerd');
        $response->assertStatus(200);
    }
}
