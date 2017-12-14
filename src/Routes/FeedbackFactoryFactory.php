<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\ActiveRecord\Record;
use pulledbits\Router\ErrorFactory;
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
        $contactmoments = $schema->read('contactmoment', [], ['id' => $matches['contactmomentIdentifier']]);
        if (count($contactmoments) === 0) {
            return ErrorFactory::makeInstance(404);
        }

        return new class($phpview, $responseFactory, $contactmoments[0]) implements ResponseFactory
        {
            private $responseFactory;
            private $phpview;
            private $contactmoment;

            public function __construct(\pulledbits\View\Directory $phpview, \pulledbits\Response\Factory $responseFactory, Record $contactmoment)
            {
                $this->responseFactory = $responseFactory;
                $this->phpview = $phpview;
                $this->contactmoment = $contactmoment;
            }

            public function makeResponse(): ResponseInterface
            {
                return $this->responseFactory->make200($this->phpview->load('feedback')->prepare(['contactmoment' => $this->contactmoment])->capture());
            }
        };
    }
}