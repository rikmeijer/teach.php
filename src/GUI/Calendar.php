<?php

namespace rikmeijer\Teach\GUI;

use pulledbits\View\Directory;
use rikmeijer\Teach\GUI;

final class Calendar implements GUI
{
    private $schema;
    /**
     * @var Directory
     */
    private $phpviewDirectory;

    public function __construct(\pulledbits\Bootstrap\Bootstrap $bootstrap)
    {
        $bootstrap->resource('calendar');
        $this->phpviewDirectory = $bootstrap->resource('phpview');
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute('/calendar/(?<calendarIdentifier>[^/]+)', new Calendar\View($this->phpviewDirectory));
    }
}
