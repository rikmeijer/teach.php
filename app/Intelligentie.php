<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intelligentie extends Model
{
    protected $table = 'intelligentie';
    protected $primaryKey = 'naam';

    public function activiteiten()
    {
        return $this->belongsToMany('App\Activiteit');
    }

    public function getNaamAttribute()
    {
        return $this->attributes['naam'];
    }
}
