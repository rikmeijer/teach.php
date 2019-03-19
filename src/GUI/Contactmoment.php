<?php
namespace rikmeijer\Teach\GUI;

use pulledbits\Router\Router;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\User;

class Contactmoment
{
    private $user;
    private $phpviewDirectory;

    public function __construct(User $user, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->user = $user;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('contactmoment');
    }

    public function importCalendarEvents() : int
    {
        return $this->user->importCalendarEvents();
    }

    public function makeRouteImport() : \pulledbits\Router\Route {
        return new Contactmoment\Import($this, $this->phpviewDirectory);
    }
}

return function(\rikmeijer\Teach\Bootstrap $bootstrap, Router $router) : void {
    $gui = new Contactmoment($bootstrap->resource('user'), $bootstrap->resource('phpview'));
    $router->addRoute('^/contactmoment/import$', λize($gui, 'makeRouteImport'));
};