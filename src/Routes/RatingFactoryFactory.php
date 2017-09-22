<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\ActiveRecord\Record;
use pulledbits\Router\ResponseFactory;

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

        return new class($phpview, $responseFactory, $contactmomentrating, $assets) implements ResponseFactory
        {
            private $responseFactory;
            private $phpview;
            private $contactmomentrating;
            private $assets;

            public function __construct(\pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory, Record $contactmomentrating, array $assets)
            {
                $this->responseFactory = $responseFactory;
                $this->phpview = $phpview;
                $this->contactmomentrating = $contactmomentrating;
                $this->assets = $assets;
            }

            public function makeResponse(): ResponseInterface
            {
                return $this->responseFactory->make200($this->phpview->capture('rating', [
                    'rating' => $this->contactmomentrating->waarde,
                    'starData' => $this->assets['star'],
                    'unstarData' => $this->assets['unstar']
                ]));
            }
        };
    }
}