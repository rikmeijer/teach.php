<?php namespace rikmeijer\Teach\Routes;

class Rating implements \pulledbits\Router\Handler
{
    private $resources;
    public function __construct(\rikmeijer\Teach\Resources $resources) {
        $this->resources = $resources;
    }

    public function handleRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $schema = $this->resources->schema();
        return $this->resources->respondWithHeaders(200, ['Content-Type' => 'image/png'], $this->resources->phpview(__DIR__ . DIRECTORY_SEPARATOR . str_replace(__NAMESPACE__ . NAMESPACE_SEPARATOR,"",__CLASS__))->capture('rating', ['rating' => $schema->readFirst('contactmomentrating', [], ['contactmoment_id' => $request->getAttribute('contactmomentIdentifier')])->waarde, 'starData' => $this->resources->readAssetStar(), 'unstarData' => $this->resources->readAssetUnstar()]));
    }
}