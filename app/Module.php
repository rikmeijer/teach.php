<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'module';

    public function lessen()
    {
        return $this->hasMany('App\Les')->orderBy('jaar', 'ASC')->orderBy('kalenderweek', 'ASC');
    }
    
    public function contactmomenten()
    {
        return $this->hasManyThrough('App\Contactmoment', 'App\Les');
    }
}
