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
VERSION:2.0
PRODID:-//Sabre//Sabre VObject 4.0.0-beta1//EN
CALSCALE:GREGORIAN
BEGIN:VEVENT
UID:sabre-vobject-2930d1fa-ac6d-42c8-92fe-06bb8bc3614e
DTSTAMP:20150603T171911Z
SUMMARY:Birthday party!
DTSTART;TZID=America/New_York:20160704T210000
DTEND;TZID=America/New_York:20160705T030000
END:VEVENT
END:VCALENDAR
VOBJECT
            )
        );

        $this->assertCount(1, $contactmomenten);
        $this->assertInstanceOf(Contactmoment::class, $contactmomenten[0]);
        $this->assertEquals('sabre-vobject-2930d1fa-ac6d-42c8-92fe-06bb8bc3614e', $contactmomenten[0]->ical_uid);
        $this->assertEquals('UTC', $contactmomenten[0]->starttijd->getTimeZone()->getName());
        $this->assertEquals('20160705T010000UTC', $contactmomenten[0]->starttijd->format('Ymd\THise'));
        $this->assertEquals('20160705T070000UTC', $contactmomenten[0]->eindtijd->format('Ymd\THise'));
    }
}
