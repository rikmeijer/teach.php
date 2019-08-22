<?php

namespace rikmeijer\Teach\GUI\Contactmoment;

use pulledbits\Router\Route;
use pulledbits\View\Directory;
use pulledbits\View\TemplateInstance;
use rikmeijer\Teach\GUI\Contactmoment;
use rikmeijer\Teach\PHPviewEndPoint;

class Import implements Route
{
    private $gui;
    private $phpviewDirectory;

    public function __construct(Contactmoment $gui, Directory $phpviewDirectory)
    {
        $this->gui = $gui;
        $this->phpviewDirectory = $phpviewDirectory;
    }

    public function handleRequest(\Psr\Http\Message\ServerRequestInterface $request): \pulledbits\Router\RouteEndPoint
    {
        switch ($request->getMethod()) {
            case 'GET':
                return $this->handleGet($request);

            case 'POST':
                return $this->handlePost($request);

            default:
                return ErrorFactory::makeInstance('405');
        }
    }

    private function handleGet(\Psr\Http\Message\ServerRequestInterface $request): \pulledbits\Router\RouteEndPoint
    {
        return new PHPviewEndPoint($this->phpviewDirectory->load('contactmoment/import', [
            'importForm' => function (TemplateInstance $templateInstance): void {
                $templateInstance->form("post", "Importeren", 'rooster.avans.nl');
            }
        ]));
    }

    private function handlePost(\Psr\Http\Message\ServerRequestInterface $request): \pulledbits\Router\RouteEndPoint
    {
        return new PHPviewEndPoint($this->phpviewDirectory->load(
            'contactmoment/imported',
            ["numberImported" => $this->gui->importRooster()]
        ));
    }
}
