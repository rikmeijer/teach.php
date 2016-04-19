<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'rating';

    public function contactmoment()
    {
        return $this->belongsTo("App\Contactmoment", "contactmoment_id");
    }
}
