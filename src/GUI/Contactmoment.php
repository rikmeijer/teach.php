<?php

namespace rikmeijer\Teach\GUI;

use rikmeijer\Teach\Calendar;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\User;

class Contactmoment implements GUI
{

    /**
     * @var Calendar
     */
    private $calendar;

    /**
     * @var User
     */
    private $user;
    private $phpviewDirectory;

    public function __construct(\pulledbits\Bootstrap\Bootstrap $bootstrap)
    {
        $this->calendar = $bootstrap->resource('calendar');
        $this->user = $bootstrap->resource('user');
        $this->phpviewDirectory = $bootstrap->resource('phpview');
    }

    public function importCalendarEvents(): int
    {
        return $this->user->importEventsFromCalendar($this->calendar);
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute('(GET|POST):/contactmoment/import', new Contactmoment\Import($this, $this->phpviewDirectory));
    }
}
