<?php


namespace rikmeijer\Teach\GUI;


use Psr\Http\Message\ServerRequestInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;
use pulledbits\Router\Router;
use pulledbits\View\Directory;
use rikmeijer\Teach\Contactmoment;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\PHPviewEndPoint;
use rikmeijer\Teach\SSO;

final class Index
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

    public function makeRoute() : Route {
        return new class($this, $this->phpviewDirectory) implements Route {
            private $gui;
            private $phpviewDirectory;

            public function __construct(\rikmeijer\Teach\GUI\Index $gui, Directory $phpviewDirectory)
            {
                $this->gui = $gui;
                $this->phpviewDirectory = $phpviewDirectory;
            }

            public function handleRequest(ServerRequestInterface $request)  : RouteEndPoint {
                return new PHPviewEndPoint($this->phpviewDirectory->load('welcome', [
                    'modules' => $this->gui->retrieveModules(),
                    'contactmomenten' => $this->gui->retrieveContactmomenten()
                ]));
            }
        };
    }
}

return function(\rikmeijer\Teach\Bootstrap $bootstrap, Router $router) : void {
    $server = $bootstrap->resource('sso');
    $schema = $bootstrap->resource('database');
    $indexGUI = new Index($server, $schema, $bootstrap->resource('phpview'));
    $router->addRoute('^/$', λize($indexGUI, 'makeRoute'));
};