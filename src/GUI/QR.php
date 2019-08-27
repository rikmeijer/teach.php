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
        $bootstrap->resource('qr');
        $this->phpviewDirectory = $bootstrap->resource('phpview');
    }

    public function createRoutes() : array
    {
        return ['/qr' => new QR\Code($this->phpviewDirectory)];
    }
}
