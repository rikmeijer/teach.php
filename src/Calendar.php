<?php


namespace rikmeijer\Teach;

use Doctrine\DBAL\Connection;
use pulledbits\Bootstrap\Bootstrap;

class Calendar
{

    /**
     * @var \ICal
     */
    private $icalReader;

    /**
     * @var Connection
     */
    private $dbal;

    /**
     * @var \rikmeijer\Teach\Daos\LesweekDao
     */
    private $lesweken;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->icalReader = $bootstrap->resource('ical');
        $this->dbal = $bootstrap->resource('tdbm')->getConnection();
        $this->lesweken = $bootstrap->resource('dao')('Lesweek');
    }

    public function importICal(string $owner, string $url) {
        $count = 0;
        $events = $this->icalReader->initURL($url);
        foreach ($events['VEVENT'] as $event) {
            if (array_key_exists('SUMMARY', $event) === false) {
                continue;
            }
            if (array_key_exists('LOCATION', $event) === false) {
                continue;
            }
            $procedureStatement = $this->dbal->prepare('CALL import_ical_to_contactmoment(:owner, :eventSummary, :eventId, :eventStartTime, :eventEndTime, :eventLocation)');
            $procedureStatement->execute([
                 'owner' => $owner,
                 'eventSummary' => $event['SUMMARY'],
                 'eventId' => $event['UID'],
                 'eventStartTime' => $this->convertToSQLDateTime($event['DTSTART']),
                 'eventEndTime' => $this->convertToSQLDateTime($event['DTEND']),
                 'eventLocation' =>$event['LOCATION']
             ]);
            $count++;
        }

        $procedureStatement = $this->dbal->prepare('CALL delete_previously_imported_future_events(:owner)');
        $procedureStatement->execute([
             'owner' => $owner
         ]);

        return $count;
    }

    private function convertToSQLDateTime(string $icaldatetime): string
    {
        try {
            $datetime = new \DateTime($icaldatetime);
            $datetime->setTimezone(new \DateTimeZone(ini_get('date.timezone')));
            return $datetime->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function generate(string $calendarIdentifier) {
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
