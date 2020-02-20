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

}
