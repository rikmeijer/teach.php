<?php


namespace rikmeijer\Teach\GUI;

use pulledbits\ActiveRecord\Schema;
use pulledbits\View\Template;
use rikmeijer\Teach\Contactmoment;
use rikmeijer\Teach\PHPViewDirectoryFactory;

final class FeedBackGUI implements GUI
{
    private $schema;
    private $phpviewDirectory;

    public function __construct(Schema $schema, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->schema = $schema;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
    }

    public function retrieveContactmoment(string $contactmomentIdentifier) : Contactmoment
    {
        return Contactmoment::read($this->schema, $contactmomentIdentifier);
    }

    public function view(array $urlParameters): Template
    {
        return $this->phpviewDirectory->load('feedback', ['contactmoment' => $this->retrieveContactmoment($urlParameters['contactmomentIdentifier'])]);
    }
}