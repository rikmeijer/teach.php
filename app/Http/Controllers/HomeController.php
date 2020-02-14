<?php

namespace App\Http\Controllers;

use App\Contactmoment;
use App\Module;
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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view(
            'welcome',
            [
                'modules' => Module::all(),
                'contactmomenten' => Contactmoment::all()
            ]
        );
    }
}
