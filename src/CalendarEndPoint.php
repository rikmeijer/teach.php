<?php

namespace rikmeijer\Teach;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;

class CalendarEndPoint implements RouteEndPoint
{
    private $wrappedEndPoint;
    private $calendarProductId;

    public function __construct(RouteEndPoint $wrappedEndPoint, string $calendarProductId)
    {
        $this->wrappedEndPoint = $wrappedEndPoint;
        $this->calendarProductId = $calendarProductId;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return $this->wrappedEndPoint->respond($psrResponse
            ->withHeader('Last-Modified', date(DATE_RFC7231))
            ->withHeader('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->withHeader('Content-Type', 'text/calendar; charset=utf-8')
            ->withHeader('Content-Disposition','attachment; filename="' . $this->calendarProductId . '.ics"'));
    }
}