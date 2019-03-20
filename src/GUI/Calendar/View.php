<?php

namespace rikmeijer\Teach\GUI\Calendar;

use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;
use pulledbits\View\Directory;
use rikmeijer\Teach\CalendarEndPoint;
use rikmeijer\Teach\PHPviewEndPoint;

class View implements Route
{
    private $phpviewDirectory;

    public function __construct(Directory $phpviewDirectory)
    {
        $this->phpviewDirectory = $phpviewDirectory;
    }

    public function handleRequest(ServerRequestInterface $request): RouteEndPoint
    {
        $phpview = new PHPviewEndPoint(
            $this->phpviewDirectory->load('calendar', ['calendarIdentifier' => $request->getAttribute('calendarIdentifier')])
        );
        return new CalendarEndPoint($phpview, $request->getAttribute('calendarIdentifier'));
    }
}
