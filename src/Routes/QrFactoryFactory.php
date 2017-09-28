<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\ResponseFactory;
use rikmeijer\Teach\Routes\Qr\Factory;

class QrFactoryFactory implements \pulledbits\Router\ResponseFactoryFactory
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

    public function makeResponseFactory(ServerRequestInterface $request): ResponseFactory
    {
        $query = $request->getQueryParams();
        $phpview = $this->resources->phpview('Qr');
        $responseFactory = $this->resources->responseFactory();

        return new Factory($phpview, $responseFactory, $query);
    }
}