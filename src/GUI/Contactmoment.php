<?php
namespace rikmeijer\Teach\GUI;

use pulledbits\Router\Router;

class Contactmoment
{
    private $user;
    private $phpviewDirectory;

    public function __construct(\rikmeijer\Teach\Bootstrap $bootstrap)
    {
        $this->user = $bootstrap->resource('user');
        $this->phpviewDirectory = $bootstrap->resource('phpview')->make('contactmoment');
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
    $gui = new Contactmoment($bootstrap);
    $router->addRoute('^/contactmoment/import$', λize($gui, 'makeRouteImport'));
};