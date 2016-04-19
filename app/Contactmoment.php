<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contactmoment extends Model
{
    protected $table = 'contactmoment';

    public function les()
    {
        return $this->belongsTo('App\Les');
    }
    
    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }
    
    public function rating()
    {
        $ratings = [];
        foreach ($this->ratings as $individualRating) {
            $ratings[] = $individualRating->waarde;
        }
        
        if (count($ratings) === 0) {
            return 0;
        } else {
            return round(array_sum($ratings) / count($ratings));
        }
    }
}
