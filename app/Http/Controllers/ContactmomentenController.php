<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Avans\Rooster;
use App\Contactmoment;
use Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

class ContactmomentenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    final public function importeerForm(): Renderable
    {
        return view('contactmomenten.importeer');
    }

    final public function importeer(Rooster $rooster): RedirectResponse
    {
        $user = Auth::user();
        $contactmomenten = $rooster->createContactmomentenFromVCalendar($user->readVCalendar());

        /** @var $contactmomenten Contactmoment[] */
        foreach ($contactmomenten as $contactmoment) {
            $contactmoment->owner()->associate($user);
        }

        return redirect()->route('contactmomenten.geimporteerd')->with('numberImported', count($contactmomenten));
    }

    final public function geimporteerd(): Renderable
    {
        return view('contactmomenten.geimporteerd');
    }
}
