<?php
namespace rikmeijer\Teach\GUI;

use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;
use pulledbits\View\Directory;
use rikmeijer\Teach\Bootstrap;
use rikmeijer\Teach\CachedEndPoint;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\ImagePngEndPoint;
use rikmeijer\Teach\PHPviewEndPoint;

class Rating implements GUI
{
    private $assets;
    private $cache;
    private $phpviewDirectory;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->assets = $bootstrap->resource('assets');
        $this->cache = $bootstrap->resource('cache');
        $this->phpviewDirectory = $bootstrap->resource('phpview')->make('');
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

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute('^/rating/(?<value>(N|[\d\.]+))$', λize($this, 'makeRoute'));
    }
}