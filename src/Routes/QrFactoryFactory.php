<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\ResponseFactory;
use rikmeijer\Teach\Routes\Qr\Factory;

class QrFactoryFactory implements \pulledbits\Router\ResponseFactoryFactory
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }


    public function matchRequest(ServerRequestInterface $request): bool
    {
        return preg_match('#^/qr#', $request->getUri()->getPath()) === 1;
    }

    public function makeResponseFactory(ServerRequestInterface $request): ResponseFactory
    {
        $query = $request->getQueryParams();
        $phpview = $this->resources->phpview('Qr');
        $responseFactory = $this->resources->responseFactory();

        return new Factory($phpview, $responseFactory, $query);
    }
}