<?php

namespace rikmeijer\Teach\GUI;

use rikmeijer\Teach\GUI;

class Contactmoment implements GUI
{
    private $user;
    private $phpviewDirectory;

    public function __construct(\pulledbits\Bootstrap\Bootstrap $bootstrap)
    {
        $this->user = $bootstrap->resource('user');
        $this->phpviewDirectory = $bootstrap->resource('phpview');
    }

    public function importCalendarEvents(): int
    {
        return $this->user->importCalendarEvents();
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute('(GET|POST):/contactmoment/import', new Contactmoment\Import($this, $this->phpviewDirectory));
    }
}
