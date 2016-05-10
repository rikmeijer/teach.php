<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Activiteit extends Controller
{
    public function create() {
        $activiteit = \App\Activiteit::create([
            'werkvorm' => \Request::get('werkvorm'),
            'organisatievorm' => \Request::get('organisatievorm'),
            'tijd' => \Request::get('tijd'),
            'werkvormsoort' => \Request::get('werkvormsoort'),
            'intelligenties' => \Request::get('intelligenties', []),
            'inhoud' => \Request::get('inhoud')
        ]);
        
        $activiteit->save();
        
        return redirect()->back()->withInput(['activiteit.created', [
            'referencing_property' => \Request::get('referencing_property'),
            'value' => $activiteit->id
        ]]);
    }
    
    public function edit(\App\Activiteit $activiteit) {
        $activiteit->werkvorm = \Request::get('werkvorm');
        $activiteit->organisatievorm = \Request::get('organisatievorm');
        $activiteit->tijd = \Request::get('tijd');
        $activiteit->werkvormsoort = \Request::get('werkvormsoort');
        $activiteit->intelligenties = \Request::get('intelligenties', []);
        $activiteit->inhoud = \Request::get('inhoud');

        $activiteit->save();
        
        return redirect()->back()->withInput(['activiteit.updated', []]);
    }
}
