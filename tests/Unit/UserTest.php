<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @noinspection PhpUndefinedFieldInspection */
    final public function testReadVCalendar(): void
    {
        $user = new User();
        $user->ical_url = tempnam(sys_get_temp_dir(), 'ical');
        file_put_contents(
            $user->ical_url,
            <<<VOBJECT
BEGIN:VCALENDAR
PRODID:-//Avans Roosters//Google Calendar 70.9054//EN
VERSION:2.0
CALSCALE:GREGORIAN
METHOD:PUBLISH
X-WR-CALNAME:Avans hameijer
X-WR-TIMEZONE:Europe/Amsterdam
X-WR-CALDESC:Avans Rooster voor hameijer

BEGIN:VEVENT
DTSTART:20200127T083500Z
DTEND:20200127T092000Z
CLASS:PUBLIC
UID:Ical20200127T09:35:0020200127T10:20:00ODS25SOPRJ11tutorenoverleghameijer@rooster.avans.nl
DTSTAMP:20120101T000000Z
CREATED:20120101T000000Z
DESCRIPTION:Groepen: 42IN-inc\n\nNB: Voor roostergegevens van voorbije blokken, raadpleeg het rooster-archief op https://rooster.avans.nl/archief
LAST-MODIFIED:20190918T042537Z
LOCATION:ODS25\, Onderwijsboulevard 215\, 5223 DE 's-Hertogenbosch
SEQUENCE:0
STATUS:CONFIRMED
SUMMARY:SOPRJ11 tutorenoverleg
TRANSP:OPAQUE
END:VEVENT
END:VCALENDAR
VOBJECT
        );

        $calendar = $user->readVCalendar();
        $event = $calendar->VEVENT;

        $this->assertEquals(
            'Ical20200127T09:35:0020200127T10:20:00ODS25SOPRJ11tutorenoverleghameijer@rooster.avans.nl',
            $event->UID
        );

        $this->assertEquals('20200127T083500UTC', $event->DTSTART->getDateTime()->format('Ymd\THise'));
        $this->assertEquals('20200127T092000UTC', $event->DTEND->getDateTime()->format('Ymd\THise'));
        $this->assertEquals('ODS25, Onderwijsboulevard 215, 5223 DE \'s-Hertogenbosch', $event->LOCATION);

        $this->assertEquals('SOPRJ11 tutorenoverleg', $event->SUMMARY);
    }
}
