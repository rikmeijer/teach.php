<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activiteit extends Model
{
    protected $table = 'activiteit';
    protected $guarded = array('id');

    const WERKVORMSOORTEN = [
        'ijsbreker' => 'IJsbreker',
        'discussie' => 'Discussie',
        'docent gecentreerd' => 'Docent gecentreerd',
        'werkopdracht' => 'Werkopdracht',
        'individuele werkopdracht' => 'Individuele werkopdracht'
    ];
    
    const ORGANISATIEVORMEN = [
        'plenair' => 'Plenair',
        'groepswerk' => 'Groepswerk',
        'circuit' => 'Circuit'
    ];
    
    const INTELLIGENTIES = [
        'VL' => 'Verbaal-Linguistisch',
        'LM' => 'Logisch-Mathematisch',
        'VR' => 'Visueel-Ruimtelijk',
        'MR' => 'Muzikaal-Ritmisch',
        'LK' => 'Lichamelijk-Kinesthetisch',
        'N' => 'Naturalistisch',
        'IR' => 'Interpersoonlijk',
        'IA' => 'Intrapersoonlijk'
    ];

    public function intelligenties()
    {
        return $this->belongsToMany('App\Intelligentie', 'activiteit_intelligentie', 'activiteit_id', 'intelligentie_naam');
    }

    public function getIntelligentiesAttribute()
    {
        $intelligenties = [];
        foreach ($this->intelligenties()->get() as $intelligentie) {
            $intelligenties[] = $intelligentie->naam;
        }
        return $intelligenties;
    }
    public function setIntelligentiesAttribute(array $value)
    {
        $this->intelligenties()->detach();
        foreach ($value as $intelligentie) {
            $this->intelligenties()->attach($intelligentie);
        }
    }
}
