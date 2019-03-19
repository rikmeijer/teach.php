<?php
namespace rikmeijer\Teach\GUI;

use pulledbits\Router\ErrorFactory;
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

    public function import(\Psr\Http\Message\ServerRequestInterface $request) : \pulledbits\Router\RouteEndPoint {
        $view = new Contactmoment\Import($this, $this->phpviewDirectory);
        switch ($request->getMethod()) {
            case 'GET':
                return $view->handleGet($request);

            case 'POST':
                return $view->handlePost($request);

            default:
                return ErrorFactory::makeInstance('405');
        }
    }
}

return function(\rikmeijer\Teach\Bootstrap $bootstrap, Router $router) : void {
    $gui = new Contactmoment($bootstrap->resource('user'), $bootstrap->resource('phpview'));
    $router->addRoute('^/contactmoment/import$', fn($gui, 'import'));
};