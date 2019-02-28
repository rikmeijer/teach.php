<?php
namespace rikmeijer\Teach\GUI;

use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Component\Event;
use pulledbits\ActiveRecord\Schema;
use pulledbits\View\Template;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\SSO;

final class CalendarUseCase implements UseCase
{
    private $server;
    private $schema;
    private $phpviewDirectory;

    public function __construct(SSO $server, Schema $schema, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->server = $server;
        $this->schema = $schema;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
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

    public function makeView(array $matches) : Template
    {
        $calendar = $this->retrieveCalendar($matches['calendarIdentifier']);
        return $this->phpviewDirectory->load('calendar', [
            'calendar' => $calendar
        ]);
    }

}