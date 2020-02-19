<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

namespace Tests\Browser;

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
}
