<?php


namespace rikmeijer\Teach\GUI;


use pulledbits\ActiveRecord\Schema;
use pulledbits\View\Template;
use rikmeijer\Teach\Contactmoment;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\SSO;

final class IndexUseCase
{
    private $server;
    private $schema;
    private $phpviewDirectory;

    public function __construct(SSO $server, Schema $schema, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->server = $server;
        $this->schema = $schema;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
    }

    private function retrieveModules(): array
    {
        $modules = [];
        foreach ($this->schema->read('module', [], []) as $module) {
            $modulecontactmomenten = Contactmoment::readByModuleName($this->schema, $this->server->getUserDetails()->uid, $module->naam);

            if (count($modulecontactmomenten) > 0) {
                $module->contains(['contactmomenten' => $modulecontactmomenten]);
                $module->bind('retrieveRating', function () {
                    $ratings = [];
                    foreach ($this->contactmomenten as $modulecontactmoment) {
                        $ratings[] = $modulecontactmoment->retrieveRating();
                    }
                    $numericRatings = array_filter($ratings, 'is_numeric');
                    if (count($numericRatings) === 0) {
                        return null;
                    }
                    return array_sum($numericRatings) / count($numericRatings);
                });

                $modules[] = $module;
            }
        }
        return $modules;
    }

    public function makeView() : Template
    {
        return $this->phpviewDirectory->load('welcome', [
            'modules' => $this->retrieveModules(),
            'contactmomenten' => Contactmoment::readVandaag($this->schema, $this->server->getUserDetails()->uid)
        ]);
    }
}