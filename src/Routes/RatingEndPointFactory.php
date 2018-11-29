<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Psr\SimpleCache\CacheInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\CachedEndPoint;
use rikmeijer\Teach\ImagePngEndPoint;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\PHPviewEndPoint;
use rikmeijer\Teach\User;

class RatingEndPointFactory implements \pulledbits\Router\RouteEndPointFactory
{
    /**
     * @var CacheInterface
     */
    private $cache;

    private $filesystem;

    private $phpviewDirectory;

    const URL_MATCH = '#^/rating/(?<value>(N|[\d\.]+))$#';

    public function __construct(CacheInterface $cache, \League\Flysystem\FilesystemInterface $filesystem, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->cache = $cache;
        $this->filesystem = $filesystem;
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

        if ($this->cache->has($eTag) === false) {
            $this->cache->set($eTag, new \DateTime());
        }

        return new CachedEndPoint(new ImagePngEndPoint(new PHPviewEndPoint($this->phpviewDirectory->load('rating', [
            'ratingwaarde' => $matches['value'] == 'N' ? null : $matches['value'],
            'ratingWidth' => 500,
            'ratingHeight' => 100,
            'repetition' => 5,
            'star' =>  $this->filesystem->read('img' . DIRECTORY_SEPARATOR . 'star.png'),
            'unstar' => $this->filesystem->read('img' . DIRECTORY_SEPARATOR . 'unstar.png'),
            'nostar' => $this->filesystem->read('img' . DIRECTORY_SEPARATOR . 'nostar.png')
        ]))), $this->cache->get($eTag), $eTag);
    }
}