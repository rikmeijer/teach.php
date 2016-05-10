<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Les extends Model
{
    protected $table = 'les';
    protected $guarded = array('id');
    
    public function module()
    {
        return $this->belongsTo('App\Module');
    }
    
    public function lesweek()
    {
        return $this->belongsTo('App\Lesweek', 'jaar', 'jaar')->where('kalenderweek', $this->kalenderweek);
    }
    
    public function doelgroep()
    {
        return $this->belongsTo('App\Doelgroep');
    }
    
    public function contactmomenten()
    {
        return $this->hasMany('App\Contactmoment')->orderBy('starttijd', 'ASC');
    }
    
    public function media()
    {
        return $this->hasMany('App\Les\Medium');
    }
    public function leerdoelen()
    {
        return $this->hasMany('App\Les\Leerdoel');
    }
    

    public function activerendeOpening()
    {
        return $this->belongsTo("App\Activiteit", "activerende_opening_id");
    }
    public function getActiverendeOpeningAttribute()
    {
        return $this->activerendeOpening()->findOrNew($this->activerende_opening_id);
    }
    public function focus()
    {
        return $this->belongsTo("App\Activiteit", "focus_id");
    }
    public function getFocusAttribute()
    {
        return $this->focus()->findOrNew($this->focus_id);
    }
    public function voorstellen()
    {
        return $this->belongsTo("App\Activiteit", "voorstellen_id");
    }
    public function getVoorstellenAttribute()
    {
        return $this->voorstellen()->findOrNew($this->voorstellen_id);
    }
    public function kennismaken()
    {
        return $this->belongsTo("App\Activiteit", "kennismaken_id");
    }
    public function getKennismakenAttribute()
    {
        return $this->kennismaken()->findOrNew($this->kennismaken_id);
    }
    
    public function themas()
    {
        return $this->hasMany('App\Thema');
    }
    
    public function huiswerk()
    {
        return $this->belongsTo("App\Activiteit", "huiswerk_id");
    }
    public function getHuiswerkAttribute()
    {
        return $this->huiswerk()->findOrNew($this->huiswerk_id);
    }
    public function evaluatie()
    {
        return $this->belongsTo("App\Activiteit", "evaluatie_id");
    }
    public function getEvaluatieAttribute()
    {
        return $this->evaluatie()->findOrNew($this->evaluatie_id);
    }
    public function pakkendSlot()
    {
        return $this->belongsTo("App\Activiteit", "pakkend_slot_id");
    }
    public function getPakkendSlotAttribute()
    {
        return $this->pakkendSlot()->findOrNew($this->pakkend_slot_id);
    }
}
