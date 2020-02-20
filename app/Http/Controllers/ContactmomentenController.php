<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class ContactmomentenController extends Controller
{

    final public function importeer(): RedirectResponse
    {
        return redirect()->route('contactmomenten.geimporteerd')->with('numberImported', 0);
    }
}
