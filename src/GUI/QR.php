<?php

namespace rikmeijer\Teach\GUI;

use pulledbits\Bootstrap\Bootstrap;
use pulledbits\Router\Route;
use pulledbits\View\TemplateInstance;
use rikmeijer\Teach\GUI;

class QR implements GUI
{
    private $phpviewDirectory;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->phpviewDirectory = $bootstrap->resource('phpview');
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute(
            '^/qr',
            function (): Route {
                return new QR\Code($this->phpviewDirectory);
            }
        );
    }
}
