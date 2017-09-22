<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ResponseFactory;

class IndexFactoryFactory implements \pulledbits\Router\ResponseFactoryFactory
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
        $schema = $this->resources->schema();
        $phpview = $this->resources->phpview('Index');
        $responseFactory = $this->resources->responseFactory();

        return new class($schema, $phpview, $responseFactory) implements ResponseFactory
        {
            private $schema;
            private $responseFactory;
            private $phpview;

            public function __construct(Schema $schema, \pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory)
            {
                $this->schema = $schema;
                $this->responseFactory = $responseFactory;
                $this->phpview = $phpview;
            }

            public function makeResponse(): ResponseInterface
            {
                return $this->responseFactory->make200($this->phpview->capture('welcome', [
                    'modules' => $this->schema->read('module', [], []),
                    'contactmomenten' => $this->schema->read('contactmoment_vandaag', [], [])
                ]));
            }
        };
    }
}