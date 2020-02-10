<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class WelcomeTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testSeeLiteralOverzichtContactmoment()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Overzicht contactmomenten');
        });
    }
}
