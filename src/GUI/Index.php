<?php


namespace rikmeijer\Teach\GUI;

use pulledbits\Router\Route;
use pulledbits\View\Directory;
use rikmeijer\Teach\Contactmoment;
use rikmeijer\Teach\GUI;

final class Index implements GUI
{
    private $user;
    private $schema;

    /**
     * @var Directory
     */
    private $phpviewDirectory;

    public function __construct(\pulledbits\Bootstrap\Bootstrap $bootstrap)
    {
        $this->user = $bootstrap->resource('user');
        $this->schema = $bootstrap->resource('database');
        $this->phpviewDirectory = $bootstrap->resource('phpview');

        $gui = $this;
        $this->phpviewDirectory->registerHelper(
            'modules',
            function () use ($gui) : array {
                return $gui->retrieveModules();
            }
        );
        $this->phpviewDirectory->registerHelper(
            'contactmomenten',
            function () use ($gui) : array {
                return $gui->retrieveContactmomenten();
            }
        );
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute(
            '^/$',
            function (): Route {
                return new Index\Index($this->phpviewDirectory);
            }
        );
    }

    public function retrieveModules(): array
    {
        $modules = [];
        $userId = $this->user->uid;
        foreach ($this->schema->read('module', [], []) as $module) {
            $modulecontactmomenten = Contactmoment::readByModuleName($this->schema, $userId, $module->naam);

            if (count($modulecontactmomenten) > 0) {
                $module->contains(['contactmomenten' => $modulecontactmomenten]);
                $module->bind(
                    'retrieveRating',
                    function () {
                        $ratings = [];
                        foreach ($this->contactmomenten as $modulecontactmoment) {
                            $ratings[] = $modulecontactmoment->retrieveRating();
                        }
                        $numericRatings = array_filter($ratings, 'is_numeric');
                        if (count($numericRatings) === 0) {
                            return null;
                        }
                        return array_sum($numericRatings) / count($numericRatings);
                    }
                );

                $modules[] = $module;
            }
        }
        return $modules;
    }

    public function retrieveContactmomenten()
    {
        return Contactmoment::readVandaag($this->schema, $this->user->uid);
    }
}
