<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

namespace Tests\Browser;

use App\Contactmoment;
use App\Les;
use App\Lesweek;
use App\Module;
use App\User;
use DateInterval;
use DateTime;
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

    final public function testSeeAuthtencatedNoContactmomentenVandaag(): void
    {
        $user = User::query()->where('email', '=', 'user@example.com')->firstOrCreate(
            [
                'email' => 'user@example.com',
                'password' => 'ss',
                'name' => 'U Ser',
            ]
        );

        try {
            $this->browse(
                static function (Browser $browser) use ($user) {
                    $browser->loginAs($user)->visit('/')
                        ->assertSee('Contactmomenten vandaag')
                        ->assertSee('Geen contactmomenten vandaag');
                }
            );
        } finally {
            $user->delete();
        }
    }


    final public function testSeeAuthenticatedContactmomentenVandaagWhenAvailable(): void
    {
        $user = User::query()->where('email', '=', 'user@example.com')->firstOrCreate(
            [
                'email' => 'user@example.com',
                'password' => 'ss',
                'name' => 'U Ser',
            ]
        );

        $lesweek = new Lesweek();
        $lesweek->jaar = '2020';
        $lesweek->kalenderweek = '8';
        $lesweek->onderwijsweek = '24';
        $lesweek->blokweek = '4';
        $lesweek->save();

        $les = new Les();
        $les->lesweek()->associate($lesweek);
        $les->module()->associate(Module::first());
        $les->save();

        $contactmoment = new Contactmoment();
        $contactmoment->starttijd = new DateTime('2020-02-18T14:40:00');
        $contactmoment->eindtijd = $contactmoment->starttijd->add(new DateInterval("PT2H"));
        $contactmoment->locatie = 'OB105';
        $contactmoment->ical_uid = uniqid('', true);
        $contactmoment->les()->associate($les);
        $user->contactmomentenVandaag()->save($contactmoment);

        try {
            $this->browse(
                static function (Browser $browser) use ($user) {
                    $browser->loginAs($user)->visit('/')
                        ->assertSee('Contactmomenten vandaag')
                        ->assertSeeIn('table#contactmomenten-vandaag tr:nth-child(1) td:nth-child(1)', 'AFST')
                        ->assertSeeIn('table#contactmomenten-vandaag tr:nth-child(1) td:nth-child(2)', '8')
                        ->assertSeeIn('table#contactmomenten-vandaag tr:nth-child(1) td:nth-child(3)', '4')
                        ->assertSeeIn('table#contactmomenten-vandaag tr:nth-child(1) td:nth-child(4)', 'Tuesday')
                        ->assertSeeIn('table#contactmomenten-vandaag tr:nth-child(1) td:nth-child(5)', '14:40')
                        ->assertSeeIn('table#contactmomenten-vandaag tr:nth-child(1) td:nth-child(6)', '16:40');
                }
            );
        } finally {
            $contactmoment->delete();
            $les->delete();
            $user->delete();
            $lesweek->delete();
        }
    }
}
