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
    
    public function media()
    {
        return $this->hasMany('App\Les\Medium');
    }

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
    
    public function themas()
    {
        return $this->hasMany('App\Thema');
    }
    
    public function huiswerk()
    {
        return $this->belongsTo("App\Activiteit", "huiswerk_id");
    }
    public function evaluatie()
    {
        return $this->belongsTo("App\Activiteit", "evaluatie_id");
    }
    public function pakkendSlot()
    {
        return $this->belongsTo("App\Activiteit", "pakkend_slot_id");
    }
}
