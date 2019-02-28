<?php


namespace rikmeijer\Teach\GUI;

use pulledbits\ActiveRecord\Schema;
use pulledbits\View\Template;
use rikmeijer\Teach\Contactmoment;
use rikmeijer\Teach\PHPViewDirectoryFactory;

final class FeedBackGUI implements \rikmeijer\Teach\GUI
{
    private $schema;
    private $phpviewDirectory;

    public function __construct(Schema $schema, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->schema = $schema;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
    }

    public function view(array $urlParameters): Template
    {
        return $this->phpviewDirectory->load('feedback', [
            'contactmoment' => Contactmoment::read($this->schema, $urlParameters['contactmomentIdentifier'])
        ]);
    }
}