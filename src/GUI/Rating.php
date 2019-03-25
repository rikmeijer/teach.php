<?php

namespace rikmeijer\Teach\GUI;

use pulledbits\Bootstrap\Bootstrap;
use pulledbits\Router\Route;
use pulledbits\View\Directory;
use pulledbits\View\TemplateInstance;
use rikmeijer\Teach\GUI;

class Rating implements GUI
{
    private $cache;
    /**
     * @var Directory
     */
    private $phpviewDirectory;

    public function __construct(Bootstrap $bootstrap)
    {
        $bootstrap->resource('assets');
        $this->cache = $bootstrap->resource('cache');
        $this->phpviewDirectory = $bootstrap->resource('phpview');

        $this->phpviewDirectory->registerHelper(
            'star',
            function (TemplateInstance $templateInstance) : string {
                return $templateInstance->image('star.png');
            }
        );
        $this->phpviewDirectory->registerHelper(
            'unstar',
            function (TemplateInstance $templateInstance): string {
                return $templateInstance->image('unstar.png');
            }
        );
        $this->phpviewDirectory->registerHelper(
            'nostar',
            function (TemplateInstance $templateInstance): string {
                return $templateInstance->image('nostar.png');
            }
        );
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute('/rating/(?<value>(N|[\d\.]+))$', new Rating\Visualize($this, $this->phpviewDirectory));
    }

    public function eTag(string $eTag)
    {
        if ($this->cache->has($eTag) === false) {
            $this->cache->set($eTag, new \DateTime());
        }
        return $this->cache->get($eTag);
    }
}
