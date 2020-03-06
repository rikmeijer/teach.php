<?php
declare(strict_types=1);

namespace App\Http\Controllers;

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

    final public function importeer(): RedirectResponse
    {
        return redirect()->route('contactmomenten.geimporteerd')->with('numberImported', 0);
    }

    final public function geimporteerd(): Renderable
    {
        return view('contactmomenten.geimporteerd');
    }
}
