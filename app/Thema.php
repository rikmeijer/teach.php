<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thema extends Model
{
    protected $table = 'thema';
    

    public function ervaren()
    {
        return $this->belongsTo("App\Activiteit", "ervaren_id");
    }
    public function getErvarenAttribute($value)
    {
        return $this->ervaren()->findOrNew($this->ervaren_id);
    }
    public function reflecteren()
    {
        return $this->belongsTo("App\Activiteit", "reflecteren_id");
    }
    public function getReflecterenAttribute($value)
    {
        return $this->reflecteren()->findOrNew($this->reflecteren_id);
    }
    public function conceptualiseren()
    {
        return $this->belongsTo("App\Activiteit", "conceptualiseren_id");
    }
    public function getConceptualiserenAttribute($value)
    {
        return $this->conceptualiseren()->findOrNew($this->conceptualiseren_id);
    }
    public function toepassen()
    {
        return $this->belongsTo("App\Activiteit", "toepassen_id");
    }
    public function getToepassenAttribute($value)
    {
        return $this->toepassen()->findOrNew($this->toepassen_id);
    }
}
