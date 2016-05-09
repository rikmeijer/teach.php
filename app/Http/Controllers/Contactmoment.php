<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class Contactmoment extends Controller
{
    
    public function importFromURL() {
        switch (\Request::get("type")) {
            case "ics":
                $url = \Request::get("url");
                $icalReader = new \ICal($url);
                
                foreach ($icalReader->events() as $event) {
                    if (array_key_exists('SUMMARY', $event) === false) {
                        continue;
                    } 
                    
                    $module = $this->extractModule($event['SUMMARY']);
                    if ($module === null) {
                        continue;
                    }
                    
                    $this->importEvent($module, new \DateTime($event['DTSTART']), new \DateTime($event['DTEND']), $event['UID'], $event['LOCATION']);
                }
                
                // remove future, imported contactmomenten which where not touched in this batch (today)
                \App\Contactmoment::where(function($query) {
                    $query->where('updated_at', '<', date('Y-m-d'))->orWhereNull('updated_at');
                })->where('starttijd', '>', date('Y-m-d'))->whereNotNull('ical_uid')->delete();
                break;
                
            case 'avansroosterjson':
                foreach (json_decode(\Request::get("json"), true) as $event) {
                    $module = $this->extractModule($event['vak']);
                    if ($module === null) {
                        continue;
                    } elseif (preg_match('/in\s+\<a[^\>]+\><span[^\>]+\>(?<ruimte>\w+)/', $event['title'], $matches) !== 1) {
                        continue;
                    }
                    
                    $ruimte = $matches['ruimte'];
                    $uid = 'Ical' . $event['start'] . $event['end'] . $ruimte . $event['vak'] . $event['param'] . '@rooster.avans.nl';
                    $uid = str_replace('-', '', $uid);
                    $uid = str_replace(' ', '', $uid);
                    $this->importEvent($module, new \DateTime($event['start']), new \DateTime($event['end']), $uid, $ruimte);
                }   
                break;
                
            default:
                return abort(500, 'Unsupported import type');
        }
        return view("contactmoment.imported");
    }
    
    private function extractModule(string $summary)
    {
        if (preg_match('/(?<module>[A-Z]+\d{1,2})/', $summary, $matches) !== 1) {
            return null;
        }
        return \App\Module::where('naam', $matches['module'])->first();
    }
    
    private function importEvent(\App\Module $module, \DateTime $starttijd, \DateTime $eindtijd, string $uid, string $ruimte) 
    {
        $starttijd->setTimezone(new \DateTimeZone(ini_get('date.timezone')));
        $eindtijd->setTimezone(new \DateTimeZone(ini_get('date.timezone')));
        
        $contactmoment = \App\Contactmoment::where('ical_uid', $uid)->first();
        if ($contactmoment === null) {
            $contactmoment = \App\Contactmoment::firstOrNew(['starttijd' => $starttijd]);
        }
        
        $contactmoment->ical_uid = $uid;
        $contactmoment->starttijd = $starttijd;
        $contactmoment->eindtijd = $eindtijd;
        $contactmoment->ruimte = $ruimte;
        
        if ($contactmoment->les === null) {
            // try to find lesplan
            $lesplan = $module->lessen()->firstOrNew([
                'jaar' => $contactmoment->starttijd->format('Y'),
                'kalenderweek' => (int)$contactmoment->starttijd->format('W')
            ]);
            $lesplan->doelgroep()->associate(\App\Doelgroep::find(1));
            $lesplan->save();
        
            $contactmoment->les()->associate($lesplan);
        }
        
        $contactmoment->save();
    }
    
}
