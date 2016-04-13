<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Les extends Model
{
    protected $table = 'les';
    
    public function module()
    {
        return $this->belongsTo('App\Module');
    }
    
    public function doelgroep()
    {
        return $this->belongsTo('App\Doelgroep');
    }
    
    public function contactmomenten()
    {
        return $this->hasMany('App\Contactmoment');
    }
}
