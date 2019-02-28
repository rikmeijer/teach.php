<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\CalendarEndPoint;
use rikmeijer\Teach\GUI\CalendarGUI;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\PHPviewEndPoint;

final class CalendarEndPointFactory implements \pulledbits\Router\RouteEndPointFactory
{
    const URI_PATTERN = '#^/calendar/(?<calendarIdentifier>[^/]+)#';

    private $useCase;
    private $phpviewDirectory;

    public function __construct(CalendarGUI $useCase, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->useCase = $useCase;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match(self::URI_PATTERN, $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        preg_match(self::URI_PATTERN, $request->getUri()->getPath(), $matches);
        $calendar = $this->retrieveCalendar($matches['calendarIdentifier']);
        return new CalendarEndPoint(new PHPviewEndPoint($this->phpviewDirectory->load('calendar', ['calendar' => $calendar])), $matches['calendarIdentifier']);
    }
}