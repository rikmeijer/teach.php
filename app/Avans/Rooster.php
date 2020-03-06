<?php
declare(strict_types=1);

namespace App\Avans;

use App\Contactmoment;
use App\Les;
use App\Lesweek;
use App\Module;
use DateTimeImmutable;
use DateTimeZone;
use Sabre\VObject\Component\VCalendar;
use Sabre\VObject\Property\ICalendar\DateTime;

class Rooster
{
    final public function createContactmomentenFromVCalendar(VCalendar $calendar): array
    {
        if (isset($calendar->VEVENT) === false) {
            return [];
        }
        $contactmomenten = [];
        foreach ($calendar->VEVENT as $event) {
            $contactmoment = new Contactmoment();
            $contactmoment->ical_uid = $event->UID;

            $starttijd = $this->convertICALDateTimeToDefaultTZDateTime($event->DTSTART);
            $contactmoment->starttijd = $starttijd;
            $contactmoment->eindtijd = $this->convertICALDateTimeToDefaultTZDateTime($event->DTEND);
            $contactmoment->locatie = $event->LOCATION->getValue();

            $lesweek = Lesweek::where(
                [
                    'jaar' => $starttijd->format('Y'),
                    'kalenderweek' => ltrim($starttijd->format('W'), '0')
                ]
            )->firstOrFail();

            preg_match('/^(\w+)\b/', $event->SUMMARY->getValue(), $matches);
            $module = Module::where(['naam' => $matches[1]])->firstOrFail();

            $contactmoment->les()->associate(
                Les::firstOrNew(
                    [
                        'lesweek_id' => $lesweek->id,
                        'module_naam' => $module->naam
                    ]
                )
            );

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
