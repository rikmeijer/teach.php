<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\ResponseFactory;

class Feedback implements \pulledbits\Router\ResponseFactoryFactory
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }

    public function matchRequest(ServerRequestInterface $request): bool
    {
        return preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $request->getUri()->getPath()) === 1;
    }

    public function makeResponseFactory(ServerRequestInterface $request): ResponseFactory
    {
        preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $request->getUri()->getPath(), $matches);

        return new class($this->resources, $this->resources->phpview('Feedback'), $this->resources->responseFactory(), $matches['contactmomentIdentifier']) implements ResponseFactory
        {
            private $resources;
            private $responseFactory;
            private $phpview;
            private $contactmomentIdentifier;

            public function __construct(\rikmeijer\Teach\Resources $resources, \pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory, string $contactmomentIdentifier)
            {
                $this->resources = $resources;
                $this->responseFactory = $responseFactory;
                $this->phpview = $phpview;
                $this->contactmomentIdentifier = $contactmomentIdentifier;
            }

            public function makeResponse(): ResponseInterface
            {
                $schema = $this->resources->schema();
                $contactmoment = $schema->readFirst('contactmoment', [], ['id' => $this->contactmomentIdentifier]);
                return $this->responseFactory->make200($this->phpview->capture('feedback', ['contactmoment' => $contactmoment]));
            }
        };
    }
}