<?php

namespace rikmeijer\Teach\GUI;

use Aura\Router\Map;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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

    public function mapRoutes(Map $map): void
    {
        $map->get('qr','/qr', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
            $view = new QR\Code($this->phpviewDirectory);
            return $view->handleRequest($request)->respond($response);
        });
    }
}
