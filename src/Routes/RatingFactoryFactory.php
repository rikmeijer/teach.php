<?php namespace rikmeijer\Teach\Routes;

use League\Flysystem\FilesystemInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\Routes\Rating\Factory;
use rikmeijer\Teach\User;

class RatingFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $user;
    private $phpviewDirectory;
    private $assets;

    public function __construct(User $user, PHPViewDirectoryFactory $phpviewDirectoryFactory, FilesystemInterface $assets)
    {
        $this->user = $user;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
        $this->assets = $assets;
    }


    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/rating/(?<contactmomentIdentifier>\d+)$#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        preg_match('#^/rating/(?<contactmomentIdentifier>\d+)#', $request->getURI()->getPath(), $matches);

        $ratingwaarde = $this->user->retrieveContactmomentRating($matches['contactmomentIdentifier']);
        return new Factory($this->phpviewDirectory->load('rating'), $ratingwaarde, [
            'star' => $this->assets->read('img' . DIRECTORY_SEPARATOR . 'star.png'),
            'unstar' => $this->assets->read('img' . DIRECTORY_SEPARATOR . 'unstar.png')
        ]);
    }
}