<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\Routes\Rating\Factory;

class RatingFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }


    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/rating/(?<contactmomentIdentifier>\d+)$#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        preg_match('#^/rating/(?<contactmomentIdentifier>\d+)#', $request->getURI()->getPath(), $matches);

        $contactmomentratings = $this->resources->schema()->read('contactmomentrating', [], ['contactmoment_id' => $matches['contactmomentIdentifier']]);
        if (count($contactmomentratings) === 0) {
            $ratingwaarde = 0;
        } elseif ($contactmomentratings[0]->waarde === null) {
            $ratingwaarde = 0;
        } else {
            $ratingwaarde = $contactmomentratings[0]->waarde;
        }

        $assets = ['star' => $this->resources->readAssetStar(), 'unstar' => $this->resources->readAssetUnstar()];

        return new Factory($this->resources->phpview('rating'), $ratingwaarde, $assets);
    }
}