<?php return new class implements \rikmeijer\Teach\Route
{
    public function __invoke(
        \Psr\Http\Message\RequestInterface $request,
        \rikmeijer\Teach\Resources $resources,
        \rikmeijer\Teach\Response $response
    ): \Psr\Http\Message\ResponseInterface {
        $schema = $resources->schema();
        return $response->make(200, $resources->phpview('welcome', [
            'modules' => $schema->read('module', [], []),
            'contactmomenten' => $schema->read('contactmoment_vandaag', [], [])
        ]));
    }
};