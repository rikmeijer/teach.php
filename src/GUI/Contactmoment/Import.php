<?php

namespace rikmeijer\Teach\GUI\Contactmoment;

use pulledbits\View\Directory;
use pulledbits\View\Template;
use pulledbits\View\TemplateInstance;
use rikmeijer\Teach\GUI\Contactmoment;

class Import
{
    private $gui;
    private $phpviewDirectory;

    public function __construct(Contactmoment $gui, Directory $phpviewDirectory)
    {
        $this->gui = $gui;
        $this->phpviewDirectory = $phpviewDirectory;
    }

    public function handleGet(): Template
    {
        return $this->phpviewDirectory->load(
            'contactmoment/import',
            [
                'importForm' => function (TemplateInstance $templateInstance): void {
                    $templateInstance->form("post", "Importeren", 'rooster.avans.nl');
                }
            ]
        );
    }

    public function handlePost(): Template
    {
        return $this->phpviewDirectory->load(
            'contactmoment/imported',
            ["numberImported" => $this->gui->importRooster()]
        );
    }
}
