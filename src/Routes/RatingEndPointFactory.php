<?php namespace rikmeijer\Teach\Routes;

use League\Flysystem\FilesystemInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\Routes\Rating\Image;
use rikmeijer\Teach\User;

class RatingEndPointFactory implements \pulledbits\Router\RouteEndPointFactory
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
        return preg_match('#^/rating/(?<contactmomentIdentifier>\d+)$#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        preg_match('#^/rating/(?<value>\d+)#', $request->getURI()->getPath(), $matches);
        return new Image($this->phpviewDirectory->load('rating'), $matches['value'], [
            'star' =>  $this->user->readPublicAsset('img' . DIRECTORY_SEPARATOR . 'star.png'),
            'unstar' => $this->user->readPublicAsset('img' . DIRECTORY_SEPARATOR . 'unstar.png')
        ]);
    }
}