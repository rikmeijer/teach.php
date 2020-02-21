<?php
declare(strict_types=1);

namespace App\Avans;

use App\Contactmoment;
use DateTimeImmutable;
use DateTimeZone;
use Sabre\VObject\Component\VCalendar;
use Sabre\VObject\Property\ICalendar\DateTime;

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
            $contactmoment->starttijd = $this->convertICALDateTimeToDefaultTZDateTime($event->DTSTART);
            $contactmoment->eindtijd = $this->convertICALDateTimeToDefaultTZDateTime($event->DTEND);
            $contactmoment->location = $event->LOCATION->getValue();
            $contactmomenten[] = $contactmoment;
        }
        return $contactmomenten;
    }

    final private function convertICALDateTimeToDefaultTZDateTime(DateTime $vdatetime): DateTimeImmutable
    {
        return $vdatetime->getDateTime()->setTimeZone(
            new DateTimeZone(date_default_timezone_get())
        );
    }
}
