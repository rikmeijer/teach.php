<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\GUI\Feedback;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\PHPviewEndPoint;

final class FeedbackEndPointFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $useCase;
    private $phpviewDirectory;

    public function __construct(Feedback $useCase, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->useCase = $useCase;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $request->getUri()->getPath(), $urlParameters);
        $contactmoment = $this->useCase->retrieveContactmoment($urlParameters['contactmomentIdentifier']);
        if ($contactmoment->id === null) {
            return ErrorFactory::makeInstance(404);
        }
        return new PHPviewEndPoint($this->phpviewDirectory->load('feedback', [
            'contactmoment' => $contactmoment
        ]));
    }
}