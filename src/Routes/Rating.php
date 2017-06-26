<?php namespace rikmeijer\Teach\Routes;

class Rating implements \pulledbits\Router\Handler
{
    private $resources;
    private $phpview;

    public function __construct(\rikmeijer\Teach\Resources $resources, \pulledbits\View\File\Template $phpview) {
        $this->resources = $resources;
        $this->phpview = $phpview;
    }

    public function handleRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $schema = $this->resources->schema();
        return $this->resources->respondWithHeaders(200, ['Content-Type' => 'image/png'], $this->phpview->capture('rating', ['rating' => $schema->readFirst('contactmomentrating', [], ['contactmoment_id' => $request->getAttribute('contactmomentIdentifier')])->waarde, 'starData' => $this->resources->readAssetStar(), 'unstarData' => $this->resources->readAssetUnstar()]));
    }
}