<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\ResponseFactory;
use rikmeijer\Teach\Routes\Index\Factory;

class IndexFactoryFactory implements \pulledbits\Router\ResponseFactoryFactory
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/#', $uri->getPath()) === 1;
    }

    public function makeResponseFactory(ServerRequestInterface $request): ResponseFactory
    {
        $user = $this->resources->userForToken($this->resources->token());
        if ($user->extra['employee'] === false) {
            return ErrorFactory::makeInstance(403);
        }

        $schema = $this->resources->schema();
        $phpview = $this->resources->phpview('Index');
        $responseFactory = $this->resources->responseFactory();

        return new Factory($schema, $phpview, $responseFactory);
    }
}