<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blokgroep extends Model
{
    protected $table = 'blokgroep';
    protected $fillable = array('code', 'collegejaar', 'nummer');

    public function blok()
    {
        return $this->belongsTo('App\Blok');
    }

}
