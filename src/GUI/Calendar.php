<?php
namespace rikmeijer\Teach\GUI;

use Eluceo\iCal\Component\Event;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\CalendarEndPoint;
use rikmeijer\Teach\PHPviewEndPoint;
use rikmeijer\Teach\SSO;

final class Calendar
{
    private $server;
    private $schema;

    public function __construct(SSO $server, Schema $schema)
    {
        $this->server = $server;
        $this->schema = $schema;
    }

    public static function view(\rikmeijer\Teach\Bootstrap $bootstrap)
    {
        $server = $bootstrap->sso();
        $schema = $bootstrap->schema();
        $calendarGUI = new self($server, $schema);

        $phpviewDirectory = $bootstrap->phpviewDirectoryFactory()->make('');
        return function(ServerRequestInterface $request) use ($calendarGUI, $phpviewDirectory): RouteEndPoint
        {
            $calendar = $calendarGUI->retrieveCalendar($request->getAttribute('calendarIdentifier'));
            return new CalendarEndPoint(new PHPviewEndPoint($phpviewDirectory->load('calendar', ['calendar' => $calendar])), $request->getAttribute('calendarIdentifier'));
        };
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

return function(\rikmeijer\Teach\Bootstrap $bootstrap) : void {
    $bootstrap->router()->addRoute('^/calendar/(?<calendarIdentifier>[^/]+)', Calendar::view($bootstrap));
};