<?php
namespace rikmeijer\Teach\GUI\Contactmoment;

use pulledbits\View\Directory;
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

    public function handleGet(\Psr\Http\Message\ServerRequestInterface $request)
    {
        return new PHPviewEndPoint($this->phpviewDirectory->load('import', [
            'importForm' => function (): void {
                $this->form("post", "Importeren", 'rooster.avans.nl');
            }
        ]));
    }

    public function handlePost(\Psr\Http\Message\ServerRequestInterface $request)
    {
        return new PHPviewEndPoint($this->phpviewDirectory->load('imported', [
            "numberImported" => $this->gui->importCalendarEvents()
        ]));

    }
}