<?php namespace rikmeijer\Teach\Routes;

use Aura\Session\Session;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\Routes\Logout\Factory;

class LogoutFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/logout#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        return new Factory($this->session);
    }
}