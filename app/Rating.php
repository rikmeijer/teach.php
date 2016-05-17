<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'rating';
    protected $fillable = array('ipv4', 'waarde', 'inhoud');

    protected $primaryKey = 'ipv4';
    
    public function contactmoment()
    {
        return $this->belongsTo("App\Contactmoment", "contactmoment_id");
    }
}
