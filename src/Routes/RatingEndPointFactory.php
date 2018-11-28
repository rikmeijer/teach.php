<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\CachedEndPoint;
use rikmeijer\Teach\ImagePngEndPoint;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\PHPviewEndPoint;
use rikmeijer\Teach\User;

class RatingEndPointFactory implements \pulledbits\Router\RouteEndPointFactory
{
    /**
     * @var User
     */
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

        $eTag = md5(($matches['value'] == 'N' ? null : $matches['value']).'500'.'100'.'5');

        if ($this->user->cached($eTag) === false) {
            $this->user->cache($eTag, new \DateTime());
        }

        return new CachedEndPoint(new ImagePngEndPoint(new PHPviewEndPoint($this->phpviewDirectory->load('rating', [
            'ratingwaarde' => $matches['value'] == 'N' ? null : $matches['value'],
            'ratingWidth' => 500,
            'ratingHeight' => 100,
            'repetition' => 5,
            'star' =>  $this->user->readPublicAsset('img' . DIRECTORY_SEPARATOR . 'star.png'),
            'unstar' => $this->user->readPublicAsset('img' . DIRECTORY_SEPARATOR . 'unstar.png'),
            'nostar' => $this->user->readPublicAsset('img' . DIRECTORY_SEPARATOR . 'nostar.png')
        ]))), $this->user->retrieveFromCache($eTag), $eTag);
    }
}