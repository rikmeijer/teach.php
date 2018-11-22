<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\Routes\Calendar\Events;
use rikmeijer\Teach\User;

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
        return new Events($this->phpviewDirectory->load('calendar', [
            'calendar' => $this->user->retrieveCalendar($matches['calendarIdentifier'])
        ]));
    }
}