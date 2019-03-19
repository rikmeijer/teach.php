<?php
namespace rikmeijer\Teach\GUI;

use Eluceo\iCal\Component\Event;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\Route;
use pulledbits\Router\Router;
use rikmeijer\Teach\PHPViewDirectoryFactory;

final class Calendar
{
    private $schema;
    private $phpviewDirectory;

    public function __construct(Schema $schema, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->schema = $schema;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
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
}

return function(\rikmeijer\Teach\Bootstrap $bootstrap, Router $router) : void {
    $schema = $bootstrap->resource('database');
    $calendarGUI = new Calendar($schema, $bootstrap->resource('phpview'));

    $router->addRoute('^/calendar/(?<calendarIdentifier>[^/]+)', λize($calendarGUI, 'makeRouteView'));
};