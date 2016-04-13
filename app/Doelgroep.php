<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doelgroep extends Model
{
    protected $table = 'doelgroep';

    public function lessen()
    {
        return $this->hasMany('App\Les');
    }
}
