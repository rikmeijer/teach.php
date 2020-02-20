<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

namespace Tests\Browser;

use App\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthenticationTest extends DuskTestCase
{
    final public function testWhen_Authenticated_Expect_Homepage(): void
    {
        $user = User::query()->where('email', '=', 'user@example.com')->firstOrCreate(
            [
                'email' => 'user@example.com',
                'password' => Hash::make('ss'),
                'name' => 'U Ser',
            ]
        );

        try {
            $this->browse(
                static function (Browser $browser) use ($user) {
                    $browser->visit('/login')
                        ->type('#email', 'user@example.com')
                        ->type('#password', 'ss')
                        ->press('Login')
                        ->waitForRoute('home')
                        ->assertAuthenticatedAs($user);
                }
            );
        } finally {
            $user->delete();
        }
    }
}
