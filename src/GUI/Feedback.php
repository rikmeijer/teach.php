<?php


namespace rikmeijer\Teach\GUI;
use rikmeijer\Teach\Contactmoment;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\GUI\Feedback\Supply;
use rikmeijer\Teach\GUI\Feedback\View;

final class Feedback implements GUI
{
    private $session;
    private $schema;
    private $phpviewDirectoryFactory;

    public function __construct(\rikmeijer\Teach\Bootstrap $bootstrap)
    {
        $this->session = $bootstrap->resource('session');
        $this->schema = $bootstrap->resource('database');
        $this->phpviewDirectoryFactory = $bootstrap->resource('phpview');
    }

    public function verifyCSRFToken(string $CSRFToken) : bool
    {
        return $this->session->getCsrfToken()->isValid($CSRFToken);
    }

    public function retrieveContactmoment(string $contactmomentIdentifier) : Contactmoment
    {
        return Contactmoment::read($this->schema, $contactmomentIdentifier);
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute('^/feedback/(?<contactmomentIdentifier>\d+)/supply$', function() : \pulledbits\Router\Route {
            return new Supply($this, $this->phpviewDirectoryFactory->make('feedback'));
        });
        $router->addRoute('^/feedback/(?<contactmomentIdentifier>\d+)', function() : \pulledbits\Router\Route {
            return new View($this, $this->phpviewDirectoryFactory->make(''));
        });
    }
}