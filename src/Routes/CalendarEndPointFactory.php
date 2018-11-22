<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\PHPviewEndPoint;
use rikmeijer\Teach\Routes\Calendar\CalendarEndPoint;
use rikmeijer\Teach\User;
use SebastianBergmann\CodeCoverage\Report\PHP;

class CalendarEndPointFactory implements \pulledbits\Router\RouteEndPointFactory
{
    const URI_PATTERN = '#^/calendar/(?<calendarIdentifier>[^/]+)#';

    private $user;
    private $phpviewDirectory;

    public function __construct(User $user, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->user = $user;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match(self::URI_PATTERN, $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        preg_match(self::URI_PATTERN, $request->getUri()->getPath(), $matches);
        $calendar = $this->user->retrieveCalendar($matches['calendarIdentifier']);
        return new CalendarEndPoint(new PHPviewEndPoint($this->phpviewDirectory->load('calendar', [
            'calendar' => $calendar
        ])), $calendar->getProdId());
    }
}