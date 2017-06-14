<?php return new class implements \rikmeijer\Teach\Route
{
    public function __invoke(
        \Psr\Http\Message\RequestInterface $request,
        \rikmeijer\Teach\Resources $resources,
        \rikmeijer\Teach\Response $response
    ): \Psr\Http\Message\ResponseInterface {
        $schema = $resources->schema();

        return $response->makeWithHeaders(200, ['Content-Type' => 'image/png'],
            $resources->phpview('rating', [
                'rating' => $schema->readFirst('contactmomentrating', [],
                    ['contactmoment_id' => $request->getAttribute('contactmomentIdentifier')])->waarde,
                'starData' => $resources->readAssetStar(),
                'unstarData' => $resources->readAssetUnstar()
            ]));
    }
};