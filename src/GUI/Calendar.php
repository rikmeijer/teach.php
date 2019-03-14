<?php
namespace rikmeijer\Teach\GUI;

use Eluceo\iCal\Component\Event;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\RouteEndPoint;
use pulledbits\Router\Router;
use rikmeijer\Teach\CalendarEndPoint;
use rikmeijer\Teach\PHPviewEndPoint;

final class Calendar
{
    private $schema;

    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
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
}

return function(\rikmeijer\Teach\Bootstrap $bootstrap, Router $router) : void {
    $schema = $bootstrap->resource('database');
    $phpviewDirectory = $bootstrap->resource('phpview')->make('');

    $router->addRoute('^/calendar/(?<calendarIdentifier>[^/]+)', function(ServerRequestInterface $request) use ($schema, $phpviewDirectory): RouteEndPoint {
        $calendarGUI = new Calendar($schema);
        $calendar = $calendarGUI->retrieveCalendar($request->getAttribute('calendarIdentifier'));
        return new CalendarEndPoint(new PHPviewEndPoint($phpviewDirectory->load('calendar', ['calendar' => $calendar])), $request->getAttribute('calendarIdentifier'));
    });
};