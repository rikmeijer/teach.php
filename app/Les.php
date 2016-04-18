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
    
    public function doelgroep()
    {
        return $this->belongsTo('App\Doelgroep');
    }
    
    public function contactmomenten()
    {
        return $this->hasMany('App\Contactmoment');
    }
    
//     public function media()
//     {
//         return $this->hasMany('App\Medium');
//     }

    public function activerendeOpening()
    {
        return $this->belongsTo("App\Activiteit", "activerende_opening_id");
    }
    public function focus()
    {
        return $this->belongsTo("App\Activiteit", "focus_id");
    }
    public function voorstellen()
    {
        return $this->belongsTo("App\Activiteit", "voorstellen_id");
    }
    public function kennismaken()
    {
        return $this->belongsTo("App\Activiteit", "kennismaken_id");
    }
}
