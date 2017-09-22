<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\ResponseFactory;
use rikmeijer\Teach\Routes\Logout\Factory;

class LogoutFactoryFactory implements \pulledbits\Router\ResponseFactoryFactory
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }

    public function matchRequest(ServerRequestInterface $request): bool
    {
        return preg_match('#^/logout#', $request->getUri()->getPath()) === 1;
    }

    public function makeResponseFactory(ServerRequestInterface $request): ResponseFactory
    {
        $session = $this->resources->session();
        $responseFactory = $this->resources->responseFactory();

        return new Factory($session, $responseFactory);
    }
}