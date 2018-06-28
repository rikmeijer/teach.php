<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use pulledbits\Router\RouteEndPointFactory;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\Routes\Qr\Code;

class QrEndPointFactory implements RouteEndPointFactory
{
    private $phpviewDirectory;

    public function __construct(PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
    }


    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/qr#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        $query = $request->getQueryParams();
        if (array_key_exists('data', $query) === false) {
            syslog(E_USER_ERROR, 'Query incomplete');
            return ErrorFactory::makeInstance('400');
        } elseif ($query['data'] === null) {
            syslog(E_USER_ERROR, 'Query data incomplete');
            return ErrorFactory::makeInstance('400');
        }
        return new Code($this->phpviewDirectory->load('qr'), $query['data']);
    }
}