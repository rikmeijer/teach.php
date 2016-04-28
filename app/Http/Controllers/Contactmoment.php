<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Contactmoment extends Controller
{
    
    public function importFromURL() {
        $url = \Request::get("url");
        
        $icalReader = new \ICal($url);
        
        foreach ($icalReader->events() as $event) {
            if (array_key_exists('SUMMARY', $event) === false) {
                continue;
            } elseif (preg_match('/(?<module>[A-Z]+\d{1,2})/', $event['SUMMARY'], $matches) !== 1) {
                continue;
            }
           
            $module = \App\Module::where('naam', $matches['module'])->first();
            if ($module === null) {
                continue;
            }
            
            $starttijd = (new \DateTime($event['DTSTART']));
            $starttijd->setTimezone(new \DateTimeZone(ini_get('date.timezone')));
            $eindtijd = (new \DateTime($event['DTEND']));
            $eindtijd->setTimezone(new \DateTimeZone(ini_get('date.timezone')));
            
            $contactmoment = \App\Contactmoment::where('ical_uid', $event['UID'])->first();
            if ($contactmoment === null) {
                $contactmoment = \App\Contactmoment::firstOrNew(['starttijd' => $starttijd]);
            }

            $contactmoment->ical_uid = $event['UID'];
            $contactmoment->starttijd = $starttijd;
            $contactmoment->eindtijd = $eindtijd;
            $contactmoment->ruimte = $event['LOCATION'];
                        
            if ($contactmoment->les === null) {
                // try to find lesplan
                $lesplan = $module->lessen()->firstOrNew([
                    'jaar' => $contactmoment->starttijd->format('Y'),
                    'kalenderweek' => $contactmoment->starttijd->format('W')
                ]);
                $lesplan->doelgroep()->associate(\App\Doelgroep::find(1));
                $lesplan->save();
                
                $contactmoment->les()->associate($lesplan);
            }
            
            $contactmoment->save();
        }
        
        // remove future, imported contactmomenten which where not touched in this batch (today)
        \App\Contactmoment::where(function($query) {
            $query->where('updated_at', '<', date('Y-m-d'))->orWhereNull('updated_at');
        })->where('starttijd', '>', date('Y-m-d'))->whereNotNull('ical_uid')->delete();
        
        return view("contactmoment.imported");
    }
    
}
