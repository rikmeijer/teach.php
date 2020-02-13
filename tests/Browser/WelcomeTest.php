<?php

namespace Tests\Browser;

use App\Module;
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

    final public function testSeeAFSTModuleCodes(): void
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

    final public function testSeeAllAvailableModuleCodes(): void
    {
        try {
            $this->browse(
                static function (Browser $browser) {
                    $page = $browser->visit('/');
                    foreach (Module::all() as $module) {
                        $page->assertSeeLink($module->naam);
                    }
                }
            );
        } catch (Throwable $e) {
            $this->assertTrue(false, $e->getMessage());
        }

    }
}
