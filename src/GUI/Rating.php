<?php


namespace rikmeijer\Teach\GUI;


use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\RouteEndPoint;
use pulledbits\Router\Router;
use rikmeijer\Teach\Bootstrap;
use rikmeijer\Teach\CachedEndPoint;
use rikmeijer\Teach\ImagePngEndPoint;
use rikmeijer\Teach\PHPviewEndPoint;

class Rating
{
}

return function(\rikmeijer\Teach\Bootstrap $bootstrap, Router $router) : void {
    $publicAssetsFileSystem = $bootstrap->resource('assets');
    $cache = $bootstrap->resource('cache');
    $phpviewDirectory = $bootstrap->resource('phpview')->make('');

    $router->addRoute('^/rating/(?<value>(N|[\d\.]+))$', function(ServerRequestInterface $request) use ($cache, $publicAssetsFileSystem, $phpviewDirectory): RouteEndPoint
    {
        $eTag = md5(($request->getAttribute('value') === 'N' ? null : $request->getAttribute('value')).'500'.'100'.'5');

        if ($cache->has($eTag) === false) {
            $cache->set($eTag, new \DateTime());
        }

        return new CachedEndPoint(new ImagePngEndPoint(new PHPviewEndPoint($phpviewDirectory->load('rating', [
            'ratingwaarde' => $request->getAttribute('value') == 'N' ? null : $request->getAttribute('value'),
            'ratingWidth' => 500,
            'ratingHeight' => 100,
            'repetition' => 5,
            'star' =>  $publicAssetsFileSystem->read('img' . DIRECTORY_SEPARATOR . 'star.png'),
            'unstar' => $publicAssetsFileSystem->read('img' . DIRECTORY_SEPARATOR . 'unstar.png'),
            'nostar' => $publicAssetsFileSystem->read('img' . DIRECTORY_SEPARATOR . 'nostar.png')
        ]))), $cache->get($eTag), $eTag);
    });
};