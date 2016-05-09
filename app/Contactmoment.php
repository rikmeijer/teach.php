<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contactmoment extends Model
{
    protected $table = 'contactmoment';
    protected $guarded = array('id');

    protected $dates = ['starttijd', 'eindtijd'];

    public function les()
    {
        return $this->belongsTo('App\Les');
    }
    
    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }
    
    public function getRatingAttribute()
    {
        $ratings = [];
        foreach ($this->ratings as $individualRating) {
            if (is_numeric($individualRating->waarde)) {
                $ratings[] = $individualRating->waarde;
            }
        }
        
        if (count($ratings) === 0) {
            return 0;
        } else {
            return round(array_sum($ratings) / count($ratings));
        }
    }
    
    public function getActiveAttribute()
    {
        $now = time();
        return $this->starttijd->format('U') <= $now && $this->eindtijd->format('U') >= $now;
    }
}
