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
    public function reflecteren()
    {
        return $this->belongsTo("App\Activiteit", "reflecteren_id");
    }
    public function conceptiualiseren()
    {
        return $this->belongsTo("App\Activiteit", "conceptiualiseren_id");
    }
    public function toepassen()
    {
        return $this->belongsTo("App\Activiteit", "toepassen_id");
    }
}
