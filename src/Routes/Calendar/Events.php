<?php


namespace rikmeijer\Teach\Routes\Calendar;


use Eluceo\iCal\Component\Calendar;
use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;

class Events implements RouteEndPoint
{
    private $phpview;
    private $calendar;

    public function __construct(\pulledbits\View\Template $phpview, Calendar $calendar)
    {
        $this->phpview = $phpview;
        $this->calendar = $calendar;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {

        return $this->phpview->prepareAsResponse($psrResponse
            ->withHeader('Last-Modified', date(DATE_RFC7231))
            ->withHeader('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->withHeader('Content-Type', 'text/calendar; charset=utf-8')
            ->withHeader('Content-Disposition','attachment; filename="' . $this->calendar->getProdId() . '.ics"'), ['calendar' => $this->calendar]);
    }
}