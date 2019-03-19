<?php
namespace rikmeijer\Teach\GUI;

use Eluceo\iCal\Component\Event;
use pulledbits\Router\Route;
use rikmeijer\Teach\GUI;

final class Calendar implements GUI
{
    private $schema;
    private $phpviewDirectory;

    public function __construct(\rikmeijer\Teach\Bootstrap $bootstrap)
    {
        $this->schema = $bootstrap->resource('database');
        $this->phpviewDirectory = $bootstrap->resource('phpview')->make('');
    }

    public function retrieveCalendar(string $calendarIdentifier) : \Eluceo\iCal\Component\Calendar {
        $calendar = new \Eluceo\iCal\Component\Calendar($calendarIdentifier);
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

    public function makeRouteView() : Route {
        return new Calendar\View($this, $this->phpviewDirectory);
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute('^/calendar/(?<calendarIdentifier>[^/]+)', λize($this, 'makeRouteView'));
    }
}