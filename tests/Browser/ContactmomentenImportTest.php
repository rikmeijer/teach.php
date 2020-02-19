<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

namespace Tests\Browser;

use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ContactmomentenImportTest extends DuskTestCase
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
}
