<?php

namespace rikmeijer\Teach\GUI\Contactmoment;

use Psr\Http\Message\ServerRequestInterface;
use pulledbits\View\Directory;
use pulledbits\View\TemplateInstance;
use rikmeijer\Teach\GUI\Contactmoment;
use rikmeijer\Teach\PHPviewEndPoint;

class Import
{
    private $gui;
    private $phpviewDirectory;

    public function __construct(Contactmoment $gui, Directory $phpviewDirectory)
    {
        $this->gui = $gui;
        $this->phpviewDirectory = $phpviewDirectory;
    }

    public function handleRequest(ServerRequestInterface $request): PHPviewEndPoint
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

    private function handleGet(ServerRequestInterface $request): PHPviewEndPoint
    {
        return new PHPviewEndPoint(
            $this->phpviewDirectory->load(
                'contactmoment/import',
                [
                    'importForm' => function (TemplateInstance $templateInstance): void {
                        $templateInstance->form("post", "Importeren", 'rooster.avans.nl');
                    }
                ]
            )
        );
    }

    private function handlePost(ServerRequestInterface $request): PHPviewEndPoint
    {
        return new PHPviewEndPoint(
            $this->phpviewDirectory->load(
                'contactmoment/imported',
                ["numberImported" => $this->gui->importRooster()]
            )
        );
    }
}
