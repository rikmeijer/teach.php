<?php

namespace rikmeijer\Teach\GUI\Calendar;

use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;
use pulledbits\View\Directory;
use rikmeijer\Teach\CalendarEndPoint;

class View implements Route
{
    private $gui;
    private $phpviewDirectory;

    public function __construct(\rikmeijer\Teach\GUI\Calendar $gui, Directory $phpviewDirectory)
    {
        $this->gui = $gui;
        $this->phpviewDirectory = $phpviewDirectory;
    }

    public function handleRequest(ServerRequestInterface $request): RouteEndPoint
    {
        $calendar = $this->gui->retrieveCalendar($request->getAttribute('calendarIdentifier'));
        $phpview = new PHPviewEndPoint(
            $this->phpviewDirectory->load('calendar', ['calendar' => $calendar])
        );
        return new CalendarEndPoint($phpview, $request->getAttribute('calendarIdentifier'));
    }
}
