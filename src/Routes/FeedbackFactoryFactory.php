<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\ActiveRecord\Record;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class FeedbackFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
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

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $request->getUri()->getPath(), $matches);

        $schema = $this->resources->schema();
        $phpview = $this->resources->phpview('Feedback');
        $contactmoments = $schema->read('contactmoment', [], ['id' => $matches['contactmomentIdentifier']]);
        if (count($contactmoments) === 0) {
            return ErrorFactory::makeInstance(404);
        }

        return new class($phpview, $contactmoments[0]) implements RouteEndPoint
        {
            private $phpview;
            private $contactmoment;

            public function __construct(\pulledbits\View\Directory $phpview, Record $contactmoment)
            {
                $this->phpview = $phpview;
                $this->contactmoment = $contactmoment;
            }

            public function respond(ResponseFactory $psrResponseFactory): ResponseInterface
            {
                return $psrResponseFactory->make(200, $this->phpview->load('feedback')->prepare(['contactmoment' => $this->contactmoment])->capture());
            }
        };
    }
}