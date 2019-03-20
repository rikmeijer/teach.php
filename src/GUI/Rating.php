<?php

namespace rikmeijer\Teach\GUI;

use pulledbits\Bootstrap\Bootstrap;
use pulledbits\Router\Route;
use rikmeijer\Teach\GUI;

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
