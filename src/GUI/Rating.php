<?php
namespace rikmeijer\Teach\GUI;

use Psr\Http\Message\ServerRequestInterface;
use Psr\SimpleCache\CacheInterface;
use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;
use pulledbits\Router\Router;
use pulledbits\View\Directory;
use rikmeijer\Teach\CachedEndPoint;
use rikmeijer\Teach\ImagePngEndPoint;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\PHPviewEndPoint;

class Rating
{
    private $assets;
    private $cache;
    private $phpviewDirectory;

    public function __construct(\League\Flysystem\FilesystemInterface $assets, CacheInterface $cache, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->assets = $assets;
        $this->cache = $cache;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
    }

    public function readImage(string $imageName) : string {
        return $this->assets->read('img' . DIRECTORY_SEPARATOR . $imageName);
    }

    public function eTag(string $eTag) {
        if ($this->cache->has($eTag) === false) {
            $this->cache->set($eTag, new \DateTime());
        }
        return $this->cache->get($eTag);
    }

    public function makeRoute() : Route {
        return new class($this, $this->phpviewDirectory) implements Route {
            private $gui;
            private $phpviewDirectory;

            public function __construct(\rikmeijer\Teach\GUI\Rating $gui, Directory $phpviewDirectory)
            {
                $this->gui = $gui;
                $this->phpviewDirectory = $phpviewDirectory;
            }

            public function handleRequest(ServerRequestInterface $request)  : RouteEndPoint {
                $eTag = md5(($request->getAttribute('value') === 'N' ? null : $request->getAttribute('value')).'500'.'100'.'5');
                return new CachedEndPoint(new ImagePngEndPoint(new PHPviewEndPoint($this->phpviewDirectory->load('rating', [
                    'ratingwaarde' => $request->getAttribute('value') == 'N' ? null : $request->getAttribute('value'),
                    'ratingWidth' => 500,
                    'ratingHeight' => 100,
                    'repetition' => 5,
                    'star' =>  $this->gui->readImage('star.png'),
                    'unstar' => $this->gui->readImage('unstar.png'),
                    'nostar' => $this->gui->readImage('nostar.png')
                ]))), $this->gui->eTag($eTag), $eTag);
            }
        };
    }
}

return function(\rikmeijer\Teach\Bootstrap $bootstrap, Router $router) : void {
    $publicAssetsFileSystem = $bootstrap->resource('assets');
    $cache = $bootstrap->resource('cache');
    $phpviewDirectoryFactory = $bootstrap->resource('phpview');

    $ratingGUI = new Rating($publicAssetsFileSystem, $cache, $phpviewDirectoryFactory);

    $router->addRoute('^/rating/(?<value>(N|[\d\.]+))$', λize($ratingGUI, 'makeRoute'));
};