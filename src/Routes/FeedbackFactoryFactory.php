<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\ActiveRecord\Record;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;
use pulledbits\View\Directory;

class FeedbackFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $schema;
    private $phpviewDirectory;

    public function __construct(Schema $schema, Directory $phpviewDirectory)
    {
        $this->schema = $schema;
        $this->phpviewDirectory = $phpviewDirectory;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $request->getUri()->getPath(), $matches);

        $contactmoments = $this->schema->read('contactmoment', [], ['id' => $matches['contactmomentIdentifier']]);
        if (count($contactmoments) === 0) {
            return ErrorFactory::makeInstance(404);
        }

        return new class($this->phpviewDirectory->load('feedback'), $contactmoments[0]) implements RouteEndPoint
        {
            private $phpview;
            private $contactmoment;

            public function __construct(\pulledbits\View\Template $phpview, Record $contactmoment)
            {
                $this->phpview = $phpview;
                $this->contactmoment = $contactmoment;
            }

            public function respond(ResponseFactory $psrResponseFactory): ResponseInterface
            {
                return $psrResponseFactory->makeWithTemplate('200', $this->phpview->prepare(['contactmoment' => $this->contactmoment]));
            }
        };
    }
}