<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\PHPViewDirectoryFactory;

class FeedbackFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $schema;
    private $phpviewDirectory;

    public function __construct(Schema $schema, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->schema = $schema;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
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

        return new Feedback\Factory($this->phpviewDirectory->load('feedback'), $contactmoments[0]);
    }
}