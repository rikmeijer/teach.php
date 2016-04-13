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
}
