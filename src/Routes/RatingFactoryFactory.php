<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\ActiveRecord\Record;
use pulledbits\Router\ResponseFactory;
use rikmeijer\Teach\Routes\Rating\Factory;

class RatingFactoryFactory implements \pulledbits\Router\ResponseFactoryFactory
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }


    public function matchRequest(ServerRequestInterface $request): bool
    {
        return preg_match('#^/rating/(?<contactmomentIdentifier>\d+)$#', $request->getUri()->getPath()) === 1;
    }

    public function makeResponseFactory(ServerRequestInterface $request): ResponseFactory
    {
        preg_match('#^/rating/(?<contactmomentIdentifier>\d+)#', $request->getUri()->getPath(), $matches);

        $contactmomentrating = $this->resources->schema()->readFirst('contactmomentrating', [], ['contactmoment_id' => $matches['contactmomentIdentifier']]);
        $phpview = $this->resources->phpview('Rating');
        $responseFactory = $this->resources->responseFactory();
        $assets = ['star' => $this->resources->readAssetStar(), 'unstar' => $this->resources->readAssetUnstar()];

        return new Factory($phpview, $responseFactory, $contactmomentrating, $assets);
    }
}