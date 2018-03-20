<?php namespace rikmeijer\Teach\Routes;

use League\Flysystem\FilesystemInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\RouteEndPoint;
use pulledbits\View\Directory;
use rikmeijer\Teach\Routes\Rating\Factory;

class RatingFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $schema;
    private $phpviewDirectory;
    private $assets;

    public function __construct(Schema $schema, Directory $phpviewDirectory, FilesystemInterface $assets)
    {
        $this->schema = $schema;
        $this->phpviewDirectory = $phpviewDirectory;
        $this->assets = $assets;
    }


    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/rating/(?<contactmomentIdentifier>\d+)$#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        preg_match('#^/rating/(?<contactmomentIdentifier>\d+)#', $request->getURI()->getPath(), $matches);

        $contactmomentratings = $this->schema->read('contactmomentrating', [], ['contactmoment_id' => $matches['contactmomentIdentifier']]);
        if (count($contactmomentratings) === 0) {
            $ratingwaarde = 0;
        } elseif ($contactmomentratings[0]->waarde === null) {
            $ratingwaarde = 0;
        } else {
            $ratingwaarde = $contactmomentratings[0]->waarde;
        }

        return new Factory($this->phpviewDirectory->load('rating'), $ratingwaarde, [
            'star' => $this->assets->read('img' . DIRECTORY_SEPARATOR . 'star.png'),
            'unstar' => $this->assets->read('img' . DIRECTORY_SEPARATOR . 'unstar.png')
        ]);
    }
}