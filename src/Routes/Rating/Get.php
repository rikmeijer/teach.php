<?php namespace rikmeijer\Teach\Routes\Rating;

class Get implements \rikmeijer\Teach\Route
{
    public function __invoke(\Psr\Http\Message\RequestInterface $request, \rikmeijer\Teach\Resources $resources): \Psr\Http\Message\ResponseInterface
    {
        $schema = $resources->schema();

        return $resources->respondWithHeaders(200, ['Content-Type' => 'image/png'], $resources->phpview(__DIR__)->capture('rating', ['rating' => $schema->readFirst('contactmomentrating', [], ['contactmoment_id' => $request->getAttribute('contactmomentIdentifier')])->waarde, 'starData' => $resources->readAssetStar(), 'unstarData' => $resources->readAssetUnstar()]));
    }
}