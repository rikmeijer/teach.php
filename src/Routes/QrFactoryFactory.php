<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use pulledbits\Router\RouteEndPointFactory;
use pulledbits\View\Directory;
use rikmeijer\Teach\Routes\Qr\Factory;

class QrFactoryFactory implements RouteEndPointFactory
{
    private $phpviewDirectory;

    public function __construct(Directory $phpviewDirectory)
    {
        $this->phpviewDirectory = $phpviewDirectory;
    }


    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/qr#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        $query = $request->getQueryParams();
        return new Factory($this->phpviewDirectory->load('qr'), $query);
    }
}