<?php

namespace rikmeijer\Teach;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;
use pulledbits\Router\RouteEndPointDecorator;

class CalendarEndPoint extends RouteEndPointDecorator
{
    private $calendarProductId;

    public function __construct(RouteEndPoint $wrappedEndPoint, string $calendarProductId)
    {
        parent::__construct($wrappedEndPoint);
        $this->calendarProductId = $calendarProductId;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        $headers = [
            'Last-Modified' => date(DATE_RFC7231),
            'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $this->calendarProductId . '.ics"'
        ];
        foreach ($headers as $header => $value) {
            $psrResponse = $psrResponse->withHeader($header, $value);
        }
        return parent::respond($psrResponse);
    }
}
