<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesweek extends Model
{
    protected $table = 'lesweek';
    
    public function contactmomenten()
    {
        return $this->hasMany('App\Les');
    }
}
