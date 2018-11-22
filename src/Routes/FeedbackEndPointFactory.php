<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\PHPviewEndPoint;
use rikmeijer\Teach\User;

class FeedbackEndPointFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $user;
    private $phpviewDirectory;

    public function __construct(User $user, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->user = $user;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $request->getUri()->getPath(), $matches);
        $contactmoment = $this->user->retrieveContactmoment($matches['contactmomentIdentifier']);
        if ($contactmoment->id !== $matches['contactmomentIdentifier']) {
            return ErrorFactory::makeInstance(404);
        }
        return new PHPviewEndPoint($this->phpviewDirectory->load('feedback', ['contactmoment' => $contactmoment]));
    }
}