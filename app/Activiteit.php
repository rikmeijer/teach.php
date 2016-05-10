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
    
    public function getIntelligentiesAttribute($value)
    {
        return explode(',', $value);
    }
    public function setIntelligentiesAttribute(array $value)
    {
        $this->attributes['intelligenties'] = join(',', $value);
    }
}
