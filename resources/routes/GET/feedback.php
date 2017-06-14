<?php return new class implements \rikmeijer\Teach\Route
{
    public function __invoke(
        \Psr\Http\Message\RequestInterface $request,
        \rikmeijer\Teach\Resources $resources
    ): \Psr\Http\Message\ResponseInterface {
        $schema = $resources->schema();
        $contactmoment = $schema->readFirst('contactmoment', [],
            ['id' => $request->getAttribute('contactmomentIdentifier')]);
        return $resources->respond(200, $resources->phpview('feedback', [
            'contactmoment' => $contactmoment
        ]));
    }
};