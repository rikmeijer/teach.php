<?php

namespace rikmeijer\Teach\GUI;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Bootstrap\Bootstrap;
use pulledbits\View\Directory;
use pulledbits\View\TemplateInstance;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\PHPviewEndPoint;

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
            function (TemplateInstance $templateInstance): string {
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
        $router->addRoute(
            '/rating/(?<value>(N|[\d\.]+))$',
            function (ServerRequestInterface $request, callable $next): ResponseInterface {
                if ($request->getAttribute('value') === 'N') {
                    $waarde = null;
                } else {
                    $waarde = $request->getAttribute('value');
                }

                $psrResponse = $next($request);
                return (new PHPviewEndPoint(
                    $this->phpviewDirectory->load(
                        'rating',
                        [
                            'ratingwaarde' => $waarde,
                            'ratingWidth' => 500,
                            'ratingHeight' => 100,
                            'repetition' => 5
                        ]
                    )
                ))->respond($psrResponse)->withHeader('Content-Type', 'image/png');
            }
        );
    }
}
