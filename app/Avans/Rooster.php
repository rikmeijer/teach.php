<?php
declare(strict_types=1);

namespace App\Avans;

use App\Contactmoment;
use Sabre\VObject\Document;

class Rooster
{
    final public function import(Document $calendar): array
    {
        if (isset($calendar->VEVENT) == false) {
            return [];
        }
        $contactmomenten = [];
        foreach ($calendar->VEVENT as $event) {
            $contactmoment = new Contactmoment();
            $contactmoment->ical_uid = $event->UID;
            $contactmomenten[] = $contactmoment;
        }
        return $contactmomenten;
    }
}
