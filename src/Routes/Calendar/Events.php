<?php

namespace rikmeijer\Teach\Routes\Calendar;

use Psr\Http\Message\ResponseInterface;
use rikmeijer\Teach\PHPviewEndPoint;

class Events extends PHPviewEndPoint
{
    private $calendarProductId;

    public function __construct(\pulledbits\View\Template $phpview, string $calendarProductId)
    {
        parent::__construct($phpview);
        $this->calendarProductId = $calendarProductId;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return parent::respond($psrResponse
            ->withHeader('Last-Modified', date(DATE_RFC7231))
            ->withHeader('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->withHeader('Content-Type', 'text/calendar; charset=utf-8')
            ->withHeader('Content-Disposition','attachment; filename="' . $this->calendarProductId . '.ics"'));
    }
}