<?php namespace rikmeijer\Teach\Routes;

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

    const URL_MATCH = '#^/rating/(?<value>(N|[\d\.]+))$#';

    public function __construct(User $user, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->user = $user;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
    }


    public function matchUri(UriInterface $uri): bool
    {
        return preg_match(self::URL_MATCH, $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        preg_match(self::URL_MATCH, $request->getURI()->getPath(), $matches);
        return new Image($this->phpviewDirectory->load('rating'), $matches['value'] == 'N' ? null : $matches['value'], [
            'star' =>  $this->user->readPublicAsset('img' . DIRECTORY_SEPARATOR . 'star.png'),
            'unstar' => $this->user->readPublicAsset('img' . DIRECTORY_SEPARATOR . 'unstar.png'),
            'nostar' => $this->user->readPublicAsset('img' . DIRECTORY_SEPARATOR . 'nostar.png')
        ]);
    }
}