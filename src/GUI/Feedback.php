<?php


namespace rikmeijer\Teach\GUI;

use Aura\Session\Session;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\Router;
use rikmeijer\Teach\Contactmoment;
use rikmeijer\Teach\GUI\Feedback\Supply;
use rikmeijer\Teach\GUI\Feedback\View;
use rikmeijer\Teach\PHPViewDirectoryFactory;

final class Feedback
{
    private $session;
    private $schema;
    private $phpviewDirectoryFactory;

    public function __construct(Session $session, Schema $schema, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->session = $session;
        $this->schema = $schema;
        $this->phpviewDirectoryFactory = $phpviewDirectoryFactory;
    }

    public function verifyCSRFToken(string $CSRFToken) : bool
    {
        return $this->session->getCsrfToken()->isValid($CSRFToken);
    }

    public function retrieveContactmoment(string $contactmomentIdentifier) : Contactmoment
    {
        return Contactmoment::read($this->schema, $contactmomentIdentifier);
    }

    public function supply(\Psr\Http\Message\ServerRequestInterface $request) : \pulledbits\Router\RouteEndPoint {
        $view = new Supply($this, $this->phpviewDirectoryFactory->make('feedback'));
        switch ($request->getMethod()) {
            case 'GET':
                return $view->handleGet($request);

            case 'POST':
                return $view->handlePost($request);
            default:
                return \pulledbits\Router\ErrorFactory::makeInstance('405');
        }
    }

    public function view(\Psr\Http\Message\ServerRequestInterface $request) : \pulledbits\Router\RouteEndPoint {
        $view = new View($this, $this->phpviewDirectoryFactory->make(''));
        return $view->handleGet($request);
    }
}

return function(\rikmeijer\Teach\Bootstrap $bootstrap, Router $router) : void {
    $feedbackGUI = new Feedback($bootstrap->resource('session'), $bootstrap->resource('database'), $bootstrap->resource('phpview'));

    $router->addRoute('^/feedback/(?<contactmomentIdentifier>\d+)/supply$', fn($feedbackGUI, 'supply'));
    $router->addRoute('^/feedback/(?<contactmomentIdentifier>\d+)', fn($feedbackGUI, 'view'));
};