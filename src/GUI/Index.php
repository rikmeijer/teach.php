<?php


namespace rikmeijer\Teach\GUI;

use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;
use pulledbits\View\Directory;
use rikmeijer\Teach\Contactmoment;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\PHPviewEndPoint;

final class Index implements GUI
{
    private $user;
    private $schema;
    private $phpviewDirectory;

    public function __construct(\rikmeijer\Teach\Bootstrap $bootstrap)
    {
        $this->user = $bootstrap->resource('user');
        $this->schema = $bootstrap->resource('database');
        $this->phpviewDirectory = $bootstrap->resource('phpview');
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute('^/$', function (): Route {
            return new class($this, $this->phpviewDirectory) implements Route
            {
                private $gui;
                private $phpviewDirectory;

                public function __construct(\rikmeijer\Teach\GUI\Index $gui, Directory $phpviewDirectory)
                {
                    $this->gui = $gui;
                    $this->phpviewDirectory = $phpviewDirectory;
                }

                public function handleRequest(ServerRequestInterface $request): RouteEndPoint
                {
                    return new PHPviewEndPoint($this->phpviewDirectory->load('welcome', [
                        'modules' => $this->gui->retrieveModules(),
                        'contactmomenten' => $this->gui->retrieveContactmomenten()
                    ]));
                }
            };
        });
    }

    public function retrieveModules(): array
    {
        $modules = [];
        $userId = $this->user->uid;
        foreach ($this->schema->read('module', [], []) as $module) {
            $modulecontactmomenten = Contactmoment::readByModuleName($this->schema, $userId, $module->naam);

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

    public function retrieveContactmomenten()
    {
        return Contactmoment::readVandaag($this->schema, $this->user->uid);
    }
}
