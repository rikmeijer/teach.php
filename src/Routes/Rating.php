<?php namespace rikmeijer\Teach\Routes;

class Rating implements \pulledbits\Router\Handler
{
    private $resources;
    private $responseFactory;
    private $phpview;

    public function __construct(\rikmeijer\Teach\Resources $resources, \pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory) {
        $this->resources = $resources;
        $this->responseFactory = $responseFactory;
        $this->phpview = $phpview;
    }

    public function handleRequest(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $schema = $this->resources->schema();
        $contactmomentrating = $schema->readFirst('contactmomentrating', [], ['contactmoment_id' => $request->getAttribute('contactmomentIdentifier')]);
        return $this->responseFactory->make(200, $this->phpview->capture('rating', [
            'rating' => $contactmomentrating->waarde,
            'starData' => $this->resources->readAssetStar(),
            'unstarData' => $this->resources->readAssetUnstar()
        ]));
    }
}