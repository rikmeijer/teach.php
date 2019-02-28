<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\CalendarEndPoint;
use rikmeijer\Teach\GUI\UseCase;
use rikmeijer\Teach\PHPviewEndPoint;

final class CalendarEndPointFactory implements \pulledbits\Router\RouteEndPointFactory
{
    const URI_PATTERN = '#^/calendar/(?<calendarIdentifier>[^/]+)#';

    private $useCase;

    public function __construct(UseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match(self::URI_PATTERN, $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        preg_match(self::URI_PATTERN, $request->getUri()->getPath(), $matches);
        return new CalendarEndPoint(new PHPviewEndPoint($this->useCase->makeView($matches)), $matches['calendarIdentifier']);
    }
}