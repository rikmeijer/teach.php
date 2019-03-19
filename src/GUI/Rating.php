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
        $this->phpviewDirectory = $bootstrap->resource('phpview');
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute('^/rating/(?<value>(N|[\d\.]+))$', function (): Route {
            return new class($this, $this->phpviewDirectory) implements Route
            {
                private $gui;
                private $phpviewDirectory;

                public function __construct(\rikmeijer\Teach\GUI\Rating $gui, Directory $phpviewDirectory)
                {
                    $this->gui = $gui;
                    $this->phpviewDirectory = $phpviewDirectory;
                }

                public function handleRequest(ServerRequestInterface $request): RouteEndPoint
                {
                    if ($request->getAttribute('value') === 'N') {
                        $waarde = null;
                    } else {
                        $waarde = $request->getAttribute('value');
                    }
                    $eTag = md5($waarde . '500' . '100' . '5');
                    $phpview = new PHPviewEndPoint($this->phpviewDirectory->load('rating', [
                        'ratingwaarde' => $waarde,
                        'ratingWidth' => 500,
                        'ratingHeight' => 100,
                        'repetition' => 5,
                        'star' => $this->gui->readImage('star.png'),
                        'unstar' => $this->gui->readImage('unstar.png'),
                        'nostar' => $this->gui->readImage('nostar.png')
                    ]));
                    return new CachedEndPoint(new ImagePngEndPoint($phpview), $this->gui->eTag($eTag), $eTag);
                }
            };
        });
    }

    public function readImage(string $imageName): string
    {
        return $this->assets->read('img' . DIRECTORY_SEPARATOR . $imageName);
    }

    public function eTag(string $eTag)
    {
        if ($this->cache->has($eTag) === false) {
            $this->cache->set($eTag, new \DateTime());
        }
        return $this->cache->get($eTag);
    }
}
