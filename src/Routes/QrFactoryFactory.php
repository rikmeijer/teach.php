<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use pulledbits\Router\RouteEndPointFactory;
use rikmeijer\Teach\Routes\Qr\Factory;

class QrFactoryFactory implements RouteEndPointFactory
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }


    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/qr#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        $query = $request->getQueryParams();
        $phpview = $this->resources->phpview('Qr');
        return new Factory($phpview, $query);
    }
}