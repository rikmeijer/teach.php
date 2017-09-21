<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\ResponseFactory;

class Index implements \pulledbits\Router\ResponseFactoryFactory
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }

    public function matchRequest(ServerRequestInterface $request): bool
    {
        return preg_match('#^/#', $request->getUri()->getPath()) === 1;
    }

    public function makeResponseFactory(ServerRequestInterface $request): ResponseFactory
    {
        return new class($this->resources, $this->resources->phpview('Index'), $this->resources->responseFactory()) implements ResponseFactory
        {
            private $resources;
            private $responseFactory;
            private $phpview;

            public function __construct(\rikmeijer\Teach\Resources $resources, \pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory)
            {
                $this->resources = $resources;
                $this->responseFactory = $responseFactory;
                $this->phpview = $phpview;
            }

            public function makeResponse(): ResponseInterface
            {
                $schema = $this->resources->schema();
                return $this->responseFactory->make200($this->phpview->capture('welcome', ['modules' => $schema->read('module', [], []), 'contactmomenten' => $schema->read('contactmoment_vandaag', [], [])]));
            }
        };
    }
}