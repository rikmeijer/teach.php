<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\PHPviewEndPoint;

final class IndexEndPointFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $useCase;

    public function __construct(GUI $useCase)
    {
        $this->useCase = $useCase;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        return new PHPviewEndPoint($this->useCase->view([]));
    }
}