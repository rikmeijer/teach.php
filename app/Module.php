<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'module';

    public function lessen()
    {
        return $this->hasMany('App\Les');
    }
}
