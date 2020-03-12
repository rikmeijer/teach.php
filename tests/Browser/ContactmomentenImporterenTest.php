<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

namespace Tests\Browser;

use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ContactmomentenImporterenTest extends DuskTestCase
{
    final public function testWhenNotAuthenticated_Expect_NoImporteerContactmomentenLink(): void
    {
        $this->browse(
            function (Browser $browser) {
                $browser->visit('/')
                    ->assertDontSeeLink('Importeer contactmomenten');
            }
        );
    }

    final public function testWhenAuthenticated_Expect_ImporteerContactmomentenLink(): void
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
                function (Browser $browser) use ($user) {
                    $browser->loginAs($user)->visit('/')
                        ->assertSeeLink('Importeer contactmomenten');
                }
            );
        } finally {
            $user->delete();
        }
    }

    final public function testWhenClickImporteerContactmomentenLink_Expect_ImporteerContactmomentenPage(): void
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
                function (Browser $browser) use ($user) {
                    $browser->loginAs($user)->visit('/')
                        ->clickLink('Importeer contactmomenten');

                    $window = collect($browser->driver->getWindowHandles())->last();
                    $browser->driver->switchTo()->window($window);
                    $browser->waitForRoute('contactmomenten.importeer')
                        ->assertSeeIn('h1', 'Importeer contactmomenten')
                        ->assertInputValue('input[type=submit]', 'Importeren');
                }
            );
        } finally {
            $user->delete();
        }
    }

    final public function testWhenContactmomentenImporteren_Expect_Confirmation(): void
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
                function (Browser $browser) use ($user) {
                    $browser->loginAs($user)->visitRoute('contactmomenten.importeer')
                        ->press('Importeren')
                        ->waitForRoute('contactmomenten.geimporteerd')
                        ->assertSee('0 contactmomenten zijn geïmporteerd');
                }
            );
        } finally {
            $user->delete();
        }
    }


    final public function testWhenContactmomentenImporterenWithActualURL_Expect_OneImported(): void
    {
        $ical_url = tempnam(sys_get_temp_dir(), 'ical');
        file_put_contents(
            $ical_url,
            <<<VOBJECT
BEGIN:VCALENDAR
PRODID:-//Avans Roosters//Google Calendar 70.9054//EN
VERSION:2.0
CALSCALE:GREGORIAN
METHOD:PUBLISH
X-WR-CALNAME:Avans hameijer
X-WR-TIMEZONE:Europe/Amsterdam
X-WR-CALDESC:Avans Rooster voor hameijer

BEGIN:VEVENT
DTSTART:20200127T083500Z
DTEND:20200127T092000Z
CLASS:PUBLIC
UID:Ical20200127T09:35:0020200127T10:20:00ODS25SOPRJ11tutorenoverleghameijer@rooster.avans.nl
DTSTAMP:20120101T000000Z
CREATED:20120101T000000Z
DESCRIPTION:Groepen: 42IN-inc\n\nNB: Voor roostergegevens van voorbije blokken, raadpleeg het rooster-archief op https://rooster.avans.nl/archief
LAST-MODIFIED:20190918T042537Z
LOCATION:ODS25\, Onderwijsboulevard 215\, 5223 DE 's-Hertogenbosch
SEQUENCE:0
STATUS:CONFIRMED
SUMMARY:SOPRJ11 tutorenoverleg
TRANSP:OPAQUE
END:VEVENT
END:VCALENDAR
VOBJECT
        );
        $user = User::query()->where('email', '=', 'user@example.com')->firstOrCreate(
            [
                'email' => 'user@example.com',
                'password' => 'ss',
                'name' => 'U Ser',
                'ical_url' => $ical_url
            ]
        );

        try {
            $this->browse(
                function (Browser $browser) use ($user) {
                    $browser->loginAs($user)->visitRoute('contactmomenten.importeer')
                        ->press('Importeren')
                        ->waitForRoute('contactmomenten.geimporteerd')
                        ->assertSee('1 contactmoment is geïmporteerd');
                }
            );
        } finally {
            $user->delete();
        }
    }
}
