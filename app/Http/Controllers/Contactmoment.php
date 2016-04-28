<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Contactmoment extends Controller
{
    
    public function importFromURL() {
        $url = \Request::get("url");
        
        
        
        return view("contactmoment.imported");
    }
    
}
