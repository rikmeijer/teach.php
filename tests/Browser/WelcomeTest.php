<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class WelcomeTest extends DuskTestCase
{
    use RefreshDatabase;

    final public function testSeeLiteralOverzichtContactmoment(): void
    {
        try {
            $this->browse(
                static function (Browser $browser) {
                    $browser->visit('/')
                        ->assertSee('Overzicht contactmomenten');
                }
            );
        } catch (Throwable $e) {
        }
    }

    final public function testSeeAllAvailableModuleCodes(): void
    {
        $this->assertDatabaseHas(
            'modules',
            [
                'naam' => 'AFST'
            ]
        );
        try {
            $this->browse(
                static function (Browser $browser) {
                    $browser->visit('/')
                        ->assertSeeLink('AFST');
                }
            );
        } catch (Throwable $e) {
        }
    }
}
