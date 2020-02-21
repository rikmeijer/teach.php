<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Avans\Rooster;
use App\Contactmoment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Sabre\VObject\Reader;
use Tests\TestCase;

class RoosterTest extends TestCase
{
    use RefreshDatabase;

    private string $emptyCalendar;
    private string $oneEventCalendar;

    final public function testWhen_NoEventsImported_Expect_EmptyListOfContactmomenten(): void
    {
        $object = new Rooster();
        /** @noinspection PhpParamsInspection */
        $this->assertCount(
            0,
            $object->importVCalendar(
                Reader::read(
                    <<<VOBJECT
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Sabre//Sabre VObject 4.0.0-beta1//EN
    CALSCALE:GREGORIAN
END:VCALENDAR
VOBJECT
                )
            )
        );
    }


    final public function testWhen_EventsImported_Expect_ListOfContactmomenten(): void
    {
        $object = new Rooster();

        /** @noinspection PhpParamsInspection */
        $contactmomenten = $object->importVCalendar(
            Reader::read(
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
            )
        );

        $this->assertCount(1, $contactmomenten);
        $this->assertInstanceOf(Contactmoment::class, $contactmomenten[0]);
        $this->assertEquals(
            'Ical20200127T09:35:0020200127T10:20:00ODS25SOPRJ11tutorenoverleghameijer@rooster.avans.nl',
            $contactmomenten[0]->ical_uid
        );
        $this->assertEquals('UTC', $contactmomenten[0]->starttijd->getTimeZone()->getName());
        $this->assertEquals('20200127T083500UTC', $contactmomenten[0]->starttijd->format('Ymd\THise'));
        $this->assertEquals('20200127T092000UTC', $contactmomenten[0]->eindtijd->format('Ymd\THise'));
        $this->assertEquals('ODS25, Onderwijsboulevard 215, 5223 DE \'s-Hertogenbosch', $contactmomenten[0]->location);
    }
}
