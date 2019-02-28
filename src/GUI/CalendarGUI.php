<?php
namespace rikmeijer\Teach\GUI;

use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Component\Event;
use pulledbits\ActiveRecord\Schema;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\SSO;

final class CalendarGUI
{
    private $server;
    private $schema;

    public function __construct(SSO $server, Schema $schema)
    {
        $this->server = $server;
        $this->schema = $schema;
    }

    public function retrieveCalendar(string $calendarIdentifier) : Calendar {
        $calendar = new Calendar($calendarIdentifier);
        switch ($calendarIdentifier) {
            case 'weeks':
                $lesweken = $this->schema->read('lesweek', [], []);
                foreach ($lesweken as $lesweek) {
                    $lesweekEvent = new Event();
                    $lesweekEvent->setNoTime(true);
                    $lesweekEvent->setUniqueId(sha1($lesweek->jaar . $lesweek->kalenderweek));
                    $lesweekEvent->setSummary('OW' .  $lesweek->onderwijsweek . '/BW' . $lesweek->blokweek);
                    try {
                        $week_start = new \DateTime();
                        $week_start->setISODate($lesweek->jaar, $lesweek->kalenderweek);
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