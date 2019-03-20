<?php

namespace rikmeijer\Teach\GUI;

use pulledbits\Bootstrap\Bootstrap;
use pulledbits\Router\Route;
use pulledbits\View\Directory;
use rikmeijer\Teach\GUI;

class Rating implements GUI
{
    private $assets;
    private $cache;
    /**
     * @var Directory
     */
    private $phpviewDirectory;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->assets = $bootstrap->resource('assets');
        $this->cache = $bootstrap->resource('cache');
        $this->phpviewDirectory = $bootstrap->resource('phpview');

        $gui = $this;
        $this->phpviewDirectory->registerHelper('star', function() use($gui) : string {
            return $gui->readImage('star.png');
        });
        $this->phpviewDirectory->registerHelper('unstar', function() use($gui) : string {
            return $gui->readImage('unstar.png');
        });
        $this->phpviewDirectory->registerHelper('nostar', function() use($gui) : string {
            return $gui->readImage('nostar.png');
        });
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute(
            '^/rating/(?<value>(N|[\d\.]+))$',
            function (): Route {
                return new Rating\Visualize($this, $this->phpviewDirectory);
            }
        );
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
