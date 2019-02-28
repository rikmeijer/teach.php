<?php


namespace rikmeijer\Teach\GUI;


use pulledbits\ActiveRecord\Schema;
use rikmeijer\Teach\Contactmoment;
use rikmeijer\Teach\SSO;

final class Index
{
    private $server;
    private $schema;

    public function __construct(SSO $server, Schema $schema)
    {
        $this->server = $server;
        $this->schema = $schema;
    }

    public function retrieveModules(): array
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

    public function retrieveContactmomenten() {
        return Contactmoment::readVandaag($this->schema, $this->server->getUserDetails()->uid);
    }
}