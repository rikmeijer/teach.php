<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\Routes\Logout\Factory;
use rikmeijer\Teach\User;

class LogoutFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/logout#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        return new Factory($this->user);
    }
}