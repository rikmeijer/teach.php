<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Thema extends Controller
{
    public function create() {
        $thema = \App\Thema::create([
            'les_id' => \Request::get('lesplan_id'),
            'leerdoel' => \Request::get('leerdoel')
        ]);
        
        $thema->save();
        
        return redirect()->back()->withInput(['thema.created', []]);
    }
}
