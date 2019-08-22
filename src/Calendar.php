<?php


namespace rikmeijer\Teach;

use Doctrine\DBAL\Connection;
use pulledbits\Bootstrap\Bootstrap;
use rikmeijer\Teach\Daos\ContactmomentDao;
use rikmeijer\Teach\Daos\LesweekDao;

class Calendar
{

    /**
     * @var \ICal
     */
    private $icalReader;

    /**
     * @var LesweekDao
     */
    private $lesweken;

    /**
     * @var ContactmomentDao
     */
    private $contactmomenten;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->icalReader = $bootstrap->resource('ical');
        $this->lesweken = $bootstrap->resource('dao')('Lesweek');
        $this->contactmomenten = $bootstrap->resource('dao')('Contactmoment');
        $this->roosterURL = $bootstrap->config('CALENDAR')['rooster-url'];
    }

    public function retrieveEvents(string $owner)
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

    public function generate(string $calendarIdentifier)
    {
        $calendar = new \Eluceo\iCal\Component\Calendar($calendarIdentifier);
        switch ($calendarIdentifier) {
            case 'weeks':
                foreach ($this->lesweken->findAll() as $lesweek) {
                    $lesweekEvent = new \Eluceo\iCal\Component\Event();
                    $lesweekEvent->setNoTime(true);
                    $lesweekEvent->setUniqueId(sha1($lesweek->getJaar() . $lesweek->getKalenderweek()));
                    $lesweekEvent->setSummary(
                        'OW' . $lesweek->getOnderwijsweek() . '/BW' . $lesweek->getBlokweek()
                    );
                    try {
                        $week_start = new \DateTime();
                        $week_start->setISODate($lesweek->getJaar(), $lesweek->getKalenderweek());
                        $lesweekEvent->setDtStart($week_start);
                        $lesweekEvent->setDtEnd($week_start);
                        $calendar->addComponent($lesweekEvent);
                    } catch (\Exception $e) {
                    }
                }
                break;

            default:
                error_log('Unknown calendar ' . $calendarIdentifier . ' requested');
                break;
        }
        return $calendar;
    }

}
