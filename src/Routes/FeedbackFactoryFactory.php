<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\ActiveRecord\Record;
use pulledbits\Router\ResponseFactory;

class FeedbackFactoryFactory implements \pulledbits\Router\ResponseFactoryFactory
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $uri->getPath()) === 1;
    }

    public function makeResponseFactory(ServerRequestInterface $request): ResponseFactory
    {
        preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $request->getUri()->getPath(), $matches);

        $schema = $this->resources->schema();
        $phpview = $this->resources->phpview('Feedback');
        $responseFactory = $this->resources->responseFactory();
        $contactmoment = $schema->readFirst('contactmoment', [], ['id' => $matches['contactmomentIdentifier']]);

        return new class($phpview, $responseFactory, $contactmoment) implements ResponseFactory
        {
            private $responseFactory;
            private $phpview;
            private $contactmoment;

            public function __construct(\pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory, Record $contactmoment)
            {
                $this->responseFactory = $responseFactory;
                $this->phpview = $phpview;
                $this->contactmoment = $contactmoment;
            }

            public function makeResponse(): ResponseInterface
            {
                return $this->responseFactory->make200($this->phpview->capture('feedback', ['contactmoment' => $this->contactmoment]));
            }
        };
    }
}