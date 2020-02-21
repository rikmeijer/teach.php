<?php
declare(strict_types=1);

namespace App\Avans;

use App\Contactmoment;
use DateTimeZone;
use Sabre\VObject\Component\VCalendar;

class Rooster
{
    final public function importVCalendar(VCalendar $calendar): array
    {
        if (isset($calendar->VEVENT) === false) {
            return [];
        }
        $contactmomenten = [];
        foreach ($calendar->VEVENT as $event) {
            $contactmoment = new Contactmoment();
            $contactmoment->ical_uid = $event->UID;
            $contactmoment->starttijd = $event->DTSTART->getDateTime()->setTimeZone(
                new DateTimeZone(date_default_timezone_get())
            );
            $contactmoment->eindtijd = $event->DTEND->getDateTime()->setTimeZone(
                new DateTimeZone(date_default_timezone_get())
            );
            $contactmomenten[] = $contactmoment;
        }
        return $contactmomenten;
    }
}
