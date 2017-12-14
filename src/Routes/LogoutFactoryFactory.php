<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\Routes\Logout\Factory;

class LogoutFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/logout#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        $session = $this->resources->session();
        return new Factory($session);
    }
}