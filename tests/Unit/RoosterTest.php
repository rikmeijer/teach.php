<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Avans\Rooster;
use PHPUnit\Framework\TestCase;
use Sabre\VObject\Reader;

class RoosterTest extends TestCase
{
    private string $vobject;

    final protected function setUp(): void
    {
        $this->vobject = <<<VOBJECT
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
VOBJECT;

    }

    final public function testWhen_EventsImported_Expect_ListOfContactmomenten(): void
    {
        $object = new Rooster();
        $this->assertCount(1, $object->import(Reader::read($this->vobject)));
    }
}
