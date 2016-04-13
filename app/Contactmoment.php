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
}
