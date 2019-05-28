<?php


namespace rikmeijer\Teach;

use Doctrine\DBAL\Connection;

class Calendar
{

    /**
     * @var Connection
     */
    private $dbal;

    public function __construct(Connection $connection)
    {
        $this->dbal = $connection;
    }

    public function importICal(string $owner, string $url) {
        $icalReader = new \ICal($url);
        $count = 0;
        foreach ($icalReader->events() as $event) {
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

}
