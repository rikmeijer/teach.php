<?php declare(strict_types=1);

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ContactmomentenImporterenTest extends TestCase
{
    use DatabaseMigrations;

    final public function testWehn_NotAuthenticated_Expect_ContactmomentenImporteerDenyAccess(): void
    {
        $response = $this->get('/contactmomenten/importeer');
        $response->assertRedirect('/login');
    }

    final public function testContactmomentenImporteer(): void
    {
        $response = $this->actingAs(
            User::firstOrCreate(
                [
                    'email' => 'user@example.com',
                    'password' => 'ss',
                    'name' => 'U Ser',
                ]
            )
        )->get('/contactmomenten/importeer');
        $response->assertStatus(200);
    }

    final public function testContactmomentenGeimporteerd(): void
    {
        $response = $this->actingAs(
            User::firstOrCreate(
                [
                    'email' => 'user@example.com',
                    'password' => 'ss',
                    'name' => 'U Ser',
                ]
            )
        )->post('/contactmomenten/importeer', []);
        $response->assertStatus(302);
        $response->assertRedirect('/contactmomenten/geimporteerd');
        $response->assertSessionHas('numberImported', 0);
    }
}
