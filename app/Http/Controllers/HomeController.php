<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Module;
use Auth;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    final public function index(): Renderable
    {
        return view(
            'welcome',
            [
                'modules' => Module::all(),
                'contactmomenten' => Auth::user() ? Auth::user()->contactmomentenVandaag : []
            ]
        );
    }
}
