<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

namespace Tests\Browser;

use App\Module;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class WelcomeTest extends DuskTestCase
{
    final public function testSeeLiteralOverzichtContactmoment(): void
    {
        $this->browse(
            static function (Browser $browser) {
                $browser->visit('/')
                    ->assertSee('Overzicht contactmomenten');
            }
        );
    }

    final public function testSeeAFSTModuleCodes(): void
    {
        $this->assertDatabaseHas(
            'modules',
            [
                'naam' => 'AFST'
            ]
        );
        $this->browse(
            static function (Browser $browser) {
                $browser->visit('/')
                    ->assertSeeLink('AFST');
            }
        );
    }

    final public function testSeeAllAvailableModuleCodes(): void
    {
        $this->browse(
            static function (Browser $browser) {
                $page = $browser->visit('/');
                foreach (Module::all() as $module) {
                    $page->assertSeeLink($module->naam);
                }
            }
        );
    }


    final public function testSeeNoContactmomentenVandaag(): void
    {
        $this->browse(
            static function (Browser $browser) {
                $browser->visit('/')
                    ->assertSee('Contactmomenten vandaag')
                    ->assertSee('Geen contactmomenten vandaag');
            }
        );
    }



//    final public function testSeeAuthtencatedNoContactmomentenVandaag(): void
//    {
//        $user = new User();
//        $user->email = 'user@example.com';
//        $user->password = 'ss';
//        $user->name = 'U Ser';
//        $user->save();
//
//        $this->assertDatabaseMissing('contactmomenten', [
//
//        ]);
//
//        try {
//            $this->browse(
//                static function (Browser $browser) use ($user) {
//                    $browser->loginAs($user)->visit('/')
//                        ->assertSee('Contactmomenten vandaag')
//                        ->assertSee('Geen contactmomenten vandaag');
//                }
//            );
//        } finally {
//            $user->delete();
//        }
//    }
}
