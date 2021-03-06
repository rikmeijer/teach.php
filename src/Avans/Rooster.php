<?php


namespace rikmeijer\Teach\Avans;


use pulledbits\Bootstrap\Bootstrap;
use rikmeijer\Teach\Daos\ContactmomentDao;
use rikmeijer\Teach\Daos\LesweekDao;

class Rooster
{

    /**
     * @var \ICal
     */
    private $icalReader;

    /**
     * @var string
     */
    private $roosterURL;

    /**
     * @var ContactmomentDao
     */
    private $contactmomenten;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->icalReader = $bootstrap->resource('ical');
        $this->contactmomenten = $bootstrap->resource('dao')('Contactmoment');
        $this->roosterURL = $bootstrap->config('CALENDAR')['rooster-url'];
    }

    public function importEventsForUser(string $owner)
    {
        $ical = $this->icalReader->initURL($this->roosterURL . $owner);
        $events = [];
        foreach ($ical['VEVENT'] as $event) {
            if (array_key_exists('SUMMARY', $event) === false) {
                continue;
            }
            if (array_key_exists('LOCATION', $event) === false) {
                continue;
            }

            $events[] = [
                'owner' => $owner,
                'eventSummary' => $event['SUMMARY'],
                'eventId' => $event['UID'],
                'eventStartTime' => $this->convertToSQLDateTime($event['DTSTART']),
                'eventEndTime' => $this->convertToSQLDateTime($event['DTEND']),
                'eventLocation' => $event['LOCATION']
            ];
        }
        return $this->contactmomenten->import($owner, $events);
    }

    private function convertToSQLDateTime(string $icaldatetime): string
    {
        try {
            $datetime = new \DateTime($icaldatetime);
            $datetime->setTimezone(new \DateTimeZone(ini_get('date.timezone')));
            return $datetime->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            error_log($e->getMessage(), E_USER_WARNING);
            return null;
        }
    }

}
